<?php

namespace App\Libs\Game;

use \DB;
use Illuminate\Support\Facades\Redis;

abstract class BaseGame
{
    public $lottery;

    protected $pk;
    protected $default_schedules = null;
    protected $default_options = null;
    protected $default_groups = null;
    protected $default_bets = null;
    protected $default_issue_prefix = null;
    protected $default_issue_suffix_length = 3;
    protected $config_table = 'system_configs';
    protected $game_table = 'games';
    protected $bet_table = 'game_bets';
    protected $option_table = 'game_options';
    protected $rebate_table = 'game_rebates';
    protected $group_table = 'game_groups';
    protected $schedule_table = 'game_schedules';
    protected $issue_table = 'game_schedule_issues';
    protected $odds_table = 'game_odds';
    protected $group_option_table = 'game_group_option';
    protected $lottery_table = 'game_lotteries';
    protected $lottery_info_table = 'game_lottery_infos';
    protected $game_fk = 'game_id';
    //默认退水
    protected $default_rebates = [
        ['trait' => 'special', 'g_key' => 'a_limit', 'g_value' => '99.22'],
        ['trait' => 'special', 'g_key' => 'b_limit', 'g_value' => '97.22'],
        ['trait' => 'special', 'g_key' => 'c_limit', 'g_value' => '96.22'],
        ['trait' => 'special', 'g_key' => 'bet_limit', 'g_value' => '10000'],
        ['trait' => 'special', 'g_key' => 'issue_limit', 'g_value' => '20000'],
        ['trait' => 'double', 'g_key' => 'a_limit', 'g_value' => '99.2'],
        ['trait' => 'double', 'g_key' => 'b_limit', 'g_value' => '97.2'],
        ['trait' => 'double', 'g_key' => 'c_limit', 'g_value' => '96.2'],
        ['trait' => 'double', 'g_key' => 'bet_limit', 'g_value' => '50000'],
        ['trait' => 'double', 'g_key' => 'issue_limit', 'g_value' => '100000'],
        ['trait' => 'serial', 'g_key' => 'a_limit', 'g_value' => '99.22'],
        ['trait' => 'serial', 'g_key' => 'b_limit', 'g_value' => '97.22'],
        ['trait' => 'serial', 'g_key' => 'c_limit', 'g_value' => '96.22'],
        ['trait' => 'serial', 'g_key' => 'bet_limit', 'g_value' => '10000'],
        ['trait' => 'serial', 'g_key' => 'issue_limit', 'g_value' => '20000'],
    ];
    /**
     * @var null 将使用date('Ymd')[eg:20190808]
     * 或者 赋值为指定数组 ['base'=>'762322','date'=>'2019-08-08']
     */
    protected $start_issue_prefix = null;

    public function __construct($game)
    {
        $this->lottery = $game;
        $this->pk = $this->lottery->id;
    }

    /**
     * @param $start_time 开始时间
     * @param $interval 期数开奖间隔
     * @param $interval_close 期数封盘提前时间间隔
     * @param $issue_toal 总期数
     * @param $start_issue_prefix 初始期号前缀, FALSE时表示当天日期 eg. 20180808
     * @param $zero_fill 后缀期号补零位数, FALSE时的期号算法为前缀期号自增
     */
    public function generateIssues($start_time = '00:00:00', $interval = 300, $ahead = 60, $issue_total = 960, $offset = 1, $day = FALSE)
    {
        $issues = [];
        $today = $day ? $day : date('Y-m-d');
        $start_issue_prefix = $this->startIssuePrefix($today);
        $start_time = sprintf("%s %s", $today, $start_time);
        $prev_end = FALSE;
        for ($i = $offset; $i <= $issue_total + $offset - 1; $i++) {

            if ($this->default_issue_suffix_length) {
                $issue_no = sprintf("%s%s", $start_issue_prefix, zero_fill($i, $this->default_issue_suffix_length));
            } else {
                $issue_no = intval($start_issue_prefix) + $i;
            }

            if ($prev_end == FALSE) {
                $prev_end = $start_time;
            }
            $lottery = date('Y-m-d H:i:s', strtotime($start_time) + $interval * ($i - $offset + 1));
            $end_time = date('Y-m-d H:i:s', strtotime($lottery) - $ahead);
            $tmp = [
                'status' => $i == 1 ? 1 : 0,
                'release' => $today,
                'game_id' => $this->pk,  //期号
                'issue' => $issue_no,  //期号
                'start_time' => $prev_end,   //上期封盘时间
                'end_time' => $end_time,     //本期封盘时间
                'open_time' => $lottery, //本期开奖时间
            ];
            $prev_end = $end_time;
            $issues[$issue_no] = $tmp;
        }
        return $issues;
    }

    protected function generateNumbers()
    {
        return [
            'issue' => '',
            'numbers' => '',
            'open_time' => '',
            'summery' => ''
        ];
    }

    public function lotteryOpen()
    {
        DB::beginTransaction();
        $result = -55;
        try {
            $data = $this->generateNumbers();
            if (!isset($data['error_code'])) {
                $result = $this->afterLottery($data);
            } else {
                return $data;
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
        return $result;
    }

    protected function afterLottery($data)
    {
        if (empty($data['issue'])) {
            return ajax_return(0, '参数异常，没有期数');

        }
        $issue = $data['issue'];

        if (!isset($data['numbers'])) {
            return ajax_return(0, '参数异常，没有开奖号码');
        }
        $numbers = $data['numbers'];
        $open_time = $data['open_time'];

        // 5.是否已存在开奖结果
        $exists = DB::table($this->lottery->table_lottery)->where(['game_id' => $this->pk, 'issue' => $issue])->first();
        if (isset($exists->sum) && $exists->sum > 0) {
            $msg = sprintf('已存在开奖结果: %s期【%s】', $exists->issue, $this->lottery->title);
            return ajax_return(0, $msg);
        }
        // 6.采集入库
        $tmp = array_merge($numbers, [
            'game_id' => $this->pk,
            'issue' => $issue,
            'open_time' => $open_time
        ]);
        DB::table($this->lottery->table_lottery)->insert($tmp);
        //分析开奖详情
        $this->lotteryInfo($issue, $numbers);
        // 入Redis
        $lotteries_value = json_encode([
            'issue'=> $issue,
            'numbers'=> $numbers
        ]);
        $lotteries_key = sprintf(config('site.latest_issue_lotteries_key'),$this->pk);
        Redis::lpush($lotteries_key,$lotteries_value);

        Redis::del(sprintf(config('site.last_issue_key'),$this->pk));
        Redis::del(sprintf(config('site.latest_counts_lotteries_key'),$this->pk));
        Redis::del(sprintf(config('site.opening_issue_key'), $this->pk));
        return $data;
    }

    protected function parseLottery($issue, $numbers)
    {
        return FALSE;
    }

    public function lotteryInfo($issue, $numbers)
    {
        $info_batch = $this->parseLottery($issue, $numbers);
        if ($info_batch) {
            DB::table($this->lottery_info_table)->where(['game_id' => $this->pk, 'issue' => $issue])->delete();
            DB::table($this->lottery_info_table)->insert($info_batch);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 彩种安装初始化
     * @return bool
     */
    public function install()
    {
        DB::transaction(function () {
            DB::table($this->config_table)->where('g_key', $this->lottery->code)->delete();
            DB::table($this->config_table)->insert(['g_key' => $this->lottery->code, 'g_value' => 1, 'g_mode' => 1]);
            DB::table($this->game_table)->where('code', $this->lottery->code)->update(['status' => 1, 'token' => md5(uniqid() . time())]);
            // 默认彩注设定
            if ($this->default_bets) {
                DB::table($this->bet_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->bet_table)->insert($this->fillIntoArray($this->default_bets, $this->game_fk, $this->pk));
            }
            // 默认彩标设定
            if ($this->default_options) {
                DB::table($this->option_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->option_table)->insert($this->fillIntoArray($this->default_options, $this->game_fk, $this->pk));
            }

            // 默认退水设定
            if ($this->default_rebates) {
                DB::table($this->rebate_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->rebate_table)->insert($this->fillIntoArray($this->default_rebates, $this->game_fk, $this->pk));
            }
            // 默认彩盘设定
            if ($this->default_groups) {
                DB::table($this->group_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->group_table)->insert($this->fillIntoArray($this->default_groups, $this->game_fk, $this->pk));
            }

            // 开盘表
            if ($this->default_schedules) {
                DB::table($this->schedule_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->issue_table)->where($this->game_fk, $this->pk)->delete();
                DB::table($this->schedule_table)->insert($this->fillIntoArray($this->default_schedules, $this->game_fk, $this->pk));
                $issues = $this->scheduleIssues($this->default_schedules);
                DB::table($this->issue_table)->insert($issues);
            }
        });
        return TRUE;
    }

    public function uninstall()
    {
        DB::transaction(function () {
            DB::table($this->config_table)->where('g_key', $this->lottery->code)->update(['g_value' => 0]);
            DB::table($this->game_table)->where('code', $this->lottery->code)->update(['token' => '']);
            DB::table($this->issue_table)->where($this->game_fk, $this->pk)->delete();
        });
        return TRUE;
    }

    public function fillIntoArray($input, $key, $value)
    {
        return collect($input)->map(function ($item, $k) use ($key, $value) {
            if (isset($item[$key])) {
                return $item;
            }
            return $item + [$key => $value];
        })->toArray();
    }

    /**
     * 彩注设置
     * @param $inputs
     * @param bool $default
     * @return bool
     */
    public function bets($inputs, $default = FALSE)
    {
        if ($default) {
            $inputs = $this->default_rebates;
        }
        if (!$inputs) {
            return FALSE;
        }
        DB::beginTransaction();
        try {
            DB::table($this->bet_table)->where($this->game_fk, $this->pk)->delete();
            DB::table($this->bet_table)->insert($this->fillIntoArray($inputs, $this->game_fk, $this->pk));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 退水设置
     * @param $inputs
     * @param bool $default
     * @return bool
     */
    public function rebates($inputs, $default = FALSE)
    {
        if ($default) {
            $inputs = $this->default_rebates;
        }
        if (!$inputs) {
            return FALSE;
        }

        DB::beginTransaction();
        try {
            DB::table($this->rebate_table)->where($this->game_fk, $this->pk)->delete();
            DB::table($this->rebate_table)->insert($this->fillIntoArray($inputs, $this->game_fk, $this->pk));
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 彩标设置
     * @param $inputs
     * @param bool $default
     * @return bool
     */
    public function options($inputs, $default = FALSE)
    {
        if ($default) {
            $inputs = $this->default_rebates;
        }
        if (!$inputs) {
            return FALSE;
        }
        DB::beginTransaction();
        try {
            DB::table($this->option_table)->where($this->game_fk, $this->pk)->delete();
            DB::table($this->option_table)->insert($this->fillIntoArray($inputs, $this->game_fk, $this->pk));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return FALSE;
        }
        return TRUE;
    }

    public function updateOption($pk, $batch)
    {
        //DB::enableQueryLog();
        DB::beginTransaction();
        try {
            //DB::table($this->option_table)->find($option_id)->update($batch);
            $this->updateBatch($this->option_table, $pk, $batch);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return FALSE;
        }
        //$logs = DB::getQueryLog();
        //return current($logs);
        return TRUE;
    }

    /**
     * 彩盘设置
     * @param $inputs
     * @param bool $default
     * @return bool
     */
    public function groups($inputs, $default = FALSE)
    {
        if ($default) {
            $inputs = $this->default_rebates;
        }
        if (!$inputs) {
            return FALSE;
        }
        DB::beginTransaction();
        try {
            DB::table($this->group_table)->where($this->game_fk, $this->pk)->delete();
            DB::table($this->group_table)->insert($this->fillIntoArray($inputs, $this->game_fk, $this->pk));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 获取起始期数前缀
     * @param bool $day
     * @return array|false|float|int|mixed|null|string
     */
    protected function startIssuePrefix($day = FALSE)
    {
        if (!$this->default_issue_prefix) {
            return $this->default_issue_prefix = $day ? date('Ymd', strtotime($day)) : date('Ymd');
        }
        if (is_array($this->default_issue_prefix)
            && isset($this->default_issue_prefix['base'])
            && isset($this->default_issue_prefix['date'])
            && $day) {
            $base_datetime = strtotime($this->default_issue_prefix['date']);
            $day_datetime = strtotime($day);
            $diff = (int)(($day_datetime - $base_datetime) / (24 * 60 * 60));
            if ($diff) {
                $issue_prefix = $this->default_issue_prefix['base'] + $diff * ($this->lottery->total);
            } else {
                $issue_prefix = $this->default_issue_prefix['base'] - $diff * ($this->lottery->total);
            }
            return $issue_prefix;
        }
        return $this->default_issue_prefix;
    }

    /**
     * 开盘计划
     * @param $fields
     * @param bool $schedule_id
     * @return bool
     */
    public function schedule($fields, $schedule_id = FALSE)
    {
        DB::beginTransaction();
        try {
            if ($schedule_id) {
                DB::table($this->schedule_table)->where('id', $schedule_id)->update($fields);
            } else {
                DB::table($this->schedule_table)->insert($fields);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 彩种开盘期数
     * @param $schedule_list
     * @param $day
     * @return array
     */
    public function scheduleIssues($schedule_list, $day)
    {
        $offset = 1;
        $issues = [];
        foreach ($schedule_list as $item) {
            if (isset($item['status']) && !$item['status']) {
                continue;
            }
            $_issues = $this->generateIssues($item['start_time'], $item['interval'], $item['ahead'], $item['total'], $offset, $day);
            $offset += count($_issues);
            $issues = array_merge($issues, $_issues);
        }
        return $issues;
    }

    /**
     * 加载盘口
     * @param $schedules
     * @param bool $default
     * @return bool|int
     */
    public function resetSchedules($schedules, $default = FALSE)
    {
        if ($default) {
            $schedules = $this->default_schedules;
        }
        $affected = FALSE;
        if (!$schedules) {
            return $affected;
        }
        DB::beginTransaction();
        try {
            $begin_time = $end_time = FALSE;
            foreach ($schedules as $schedule) {
                $start_time = strtotime(date('Y-m-d') . ' ' . $schedule['start_time']);
                if ($begin_time == FALSE) {
                    $begin_time = $start_time;
                }
                $end_time = $start_time + $schedule['total'] * $schedule['interval'];
            }
            $begin_hi = intval(date('Gi', $begin_time));
            $end_hi = intval(date('Gi', $end_time));
            //隔天结束
            $day = date('Y-m-d');
            if ($begin_hi > $end_hi) {
                $end_time -= 24 * 3600;
                if (time() < $end_time) {
                    $day = date('Y-m-d', strtotime('-1 day'));
                }
            }
            DB::table($this->issue_table)->where($this->game_fk, $this->pk)->where(DB::raw("DATE(`release`)"), $day)->update(['status' => -1]);
            $issues = $this->scheduleIssues($schedules, $day);
            DB::table($this->issue_table)->insert($issues);
            $affected = count($issues);//DB::getPdo()->lastInsertId();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        return $affected;
    }

    /**
     * 按期数删除开奖记录
     * @param $issue
     * @return bool
     */
    public function deleteIssue($issue)
    {
        DB::beginTransaction();
        try {
            DB::table($this->lottery_table)->where(['game_id'=>$this->pk,'issue'=>$issue])->delete();
            DB::table($this->lottery_info_table)->where(['game_id'=>$this->pk,'issue'=>$issue])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 批量清理指定日期前的开奖数据
     * @param bool $day
     * @return bool
     */
    public function clearIssues($day=FALSE)
    {
        if($day==FALSE){
            $day = date('Y-m-d',strtotime('-1 month'));
        }
        DB::beginTransaction();
        try {
            $issues = DB::table($this->lottery_table)->select('issue')->where('game_id', $this->pk)->where(DB::raw('DATE(open_time)') ,'<=', $day)->get()->pluck('issue');
            DB::table($this->lottery_table)->where('game_id', $this->pk)->whereIn('issue',$issues)->delete();
            DB::table($this->lottery_info_table)->where('game_id', $this->pk)->whereIn('issue',$issues)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 修改开奖结果
     * @param $data
     * @return bool
     */
    public function modifyIssue($data)
    {
        $ret = FALSE;
        if(empty($data['issue']) || empty($data['open_time']) || empty($data['numbers']) || !is_array($data['numbers'])){
            return FALSE;
        }
        $issue = $data['issue'];
        DB::beginTransaction();
        try {
            DB::table($this->lottery_table)->where(['game_id'=>$this->pk,'issue'=>$issue])->delete();
            DB::table($this->lottery_table)->insert(array_merge($data['numbers'],[
                'game_id'=>$this->pk,
                'issue'=>$issue,
                'open_time'=>$data['open_time']
            ]));
            $ret = $this->lotteryInfo($issue,$data['numbers']);
            if(!empty($data['resettle'])){
                $this->settleIssueOrders($issue);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $ret;
    }

    /**
     * 指定期号结算注单
     * @param $issue
     */
    public function settleIssueOrders($issue){

    }

    /**
     * 指定期号恢复到未结算状态
     * @param $issue
     * @return bool
     */
    public function resettleIssueOrder($issue)
    {

        $ret = FALSE;
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $ret;
    }
    /**
     * 默认赔率
     * @param $odds
     * @return bool
     */
    public function defaultOdds($odds)
    {
        DB::beginTransaction();
        try {
            $tmp = [];
            foreach ($odds as $group_id => $group) {
                foreach ($group as $option_id => $option) {
                    foreach ($option as $bet_id => $default) {
                        if (!isset($default['d'])) {
                            continue;
                        }
                        $tmp[] = [
                            'group_id' => $group_id,
                            'option_id' => $option_id,
                            'bet_id' => $bet_id,
                            'roulette' => 'd',
                            'g_value' => (float)$default['d'],
                        ];
                    }
                }
                //更新redis
                $key = sprintf(config('site.game_group_odds_key'),$group_id);
                Redis::del($key);
            }
            if ($tmp) {
                DB::table($this->odds_table)->where('roulette', 'd')->whereIn('group_id', DB::table($this->group_table)->where('game_id', $this->pk)->get()->pluck('id')->toArray())->delete();
                DB::table($this->odds_table)->insert($tmp);
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 赔率设置
     * @param $group_id
     * @param $option
     * @param array $bets
     * @return bool
     */
    public function odds($group_id, $option, $bets = array())
    {
        if (!$group_id || !isset($option['id'])) {
            return -1;
        }
        $option_id = (int)$option['id'];
        DB::beginTransaction();
        try {
            DB::table($this->odds_table)->where(['group_id' => $group_id, 'option_id' => $option_id])->delete();
            DB::table($this->group_option_table)->where(['group_id' => $group_id, 'option_id' => $option_id])->delete();
            $option_join = !empty($option['join']);
            //解除关系
            if ($option_join) {
                //group_option
                $option_update = [];
                if (isset($option['diff_b']) && is_numeric($option['diff_b'])) {
                    $option_update['diff_b'] = $option['diff_b'];
                }
                if (isset($option['diff_c']) && is_numeric($option['diff_c'])) {
                    $option_update['diff_c'] = $option['diff_c'];
                }
                if ($option_update) {
                    DB::table($this->option_table)->where('id', $option_id)->update($option_update);
                }
                $group_option = [
                    'group_id' => $group_id,
                    'option_id' => $option_id,
                    'show' => isset($option['show']) ? (int)$option['show'] : 1,
                    'remark' => isset($option['remark']) ? $option['remark'] : '',
                    'repeat' => isset($option['repeat']) ? $option['repeat'] : 'horizontal',
                    'max' => isset($option['max']) ? (int)$option['max'] : 5,
                    'style' => isset($option['style']) ? trim($option['style']) : '',
                    'sort' => isset($option['sort']) ? (int)($option['sort']) : 0,
                ];
                DB::table($this->group_option_table)->insert($group_option);
                //odds
                $batch = [];
                foreach ($bets as $bet_id => $bet) {
                    if (!is_array($bet)) {
                        continue;
                    }
                    if (empty($bet['join'])) {
                        continue;
                    }
                    foreach ($bet as $k => $value) {
                        if (strtolower($k) == 'join') {
                            continue;
                        }
                        $batch[] = [
                            'group_id' => $group_id,
                            'option_id' => $option_id,
                            'bet_id' => $bet_id,
                            'roulette' => strtolower(trim($k)),
                            'g_value' => is_numeric($value) ? $value : 0
                        ];
                    }
                }
                if ($batch) {
                    DB::table($this->odds_table)->insert($batch);
                }

            }
            DB::commit();
            //更新redis
            $key = sprintf(config('site.game_group_odds_key'),$group_id);
            Redis::del($key);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return FALSE;
        }
        return TRUE;
    }

    /*
     * 批量更新
     */
    protected function updateBatch($tableName, $pk, $multipleData = array())
    {
        try {
            if (!$pk) {
                throw new \Exception("pk数据不能为空");
            }
            if (empty($multipleData)) {
                throw new \Exception("multipleData数据不能为空");
            }

            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets = [];
            $bindings = [];
            foreach ($multipleData as $update) {

                if (!isset($update[$pk])) {
                    throw new \Exception("数据行内无更新主键");
                }

                foreach ($update as $_field => $_value) {
                    if ($_field == $pk) {
                        continue;
                    }
                    $setSql = "`" . $_field . "` = CASE ";

                    $setSql .= "WHEN `" . $pk . "` = ? THEN ? ";
                    $bindings[] = $update[$pk];
                    $bindings[] = $_value;

                    $setSql .= "ELSE `" . $_field . "` END ";
                    $sets[] = $setSql;
                }
            }

            $updateSql .= implode(', ', $sets);
            $whereIn = collect($multipleData)->pluck($pk)->values()->all();
            $bindings = array_merge($bindings, $whereIn);
            $whereIn = rtrim(str_repeat('?,', count($whereIn)), ',');

            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $pk . "` IN (" . $whereIn . ")";
            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }
}