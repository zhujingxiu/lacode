<?php

use Illuminate\Database\Seeder;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('games')->insert([
            [
                'title' => '重慶時時彩',
                'code' => 'GameCqssc',
                'total' => '59',
                'table_lottery' => 'game_lotteries',
                'status'=>1,
                'sort'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => '北京賽車PK10',
                'code' => 'GamePk10',
                'total' => '44',
                'table_lottery' => 'game_lotteries',
                'status'=>1,
                'sort'=>2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => '幸運飛艇',
                'code' => 'GameXyft',
                'total' => '180',
                'table_lottery' => 'game_lotteries',
                'status'=>1,
                'sort'=>3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => '極速賽車',
                'code' => 'GameJssc',
                'total' => '960',
                'table_lottery' => 'game_lotteries',
                'status'=>1,
                'sort'=>4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => '極速時時彩',
                'code' => 'GameJsssc',
                'total' => '960',
                'table_lottery' => 'game_lotteries',
                'status'=>1,
                'sort'=>5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        /**
         *
        INSERT INTO `game_options` VALUES (null, '1', '第一球', 'opt_1', '1', '0.200', '0.300','special');
        INSERT INTO `game_options` VALUES (null, '1', '第二球', 'opt_2', '2', '0.200', '0.300','special');
        INSERT INTO `game_options` VALUES (null, '1', '第三球', 'opt_3', '3', '0.200', '0.300','special');
        INSERT INTO `game_options` VALUES (null, '1', '第四球', 'opt_4', '4', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '第五球', 'opt_5', '5', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '1-5大小', 'opt_dx', '6', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '1-5單雙', 'opt_ds', '7', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '总和大小', 'opt_dx2', '8', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '总和單雙', 'opt_ds2', '9', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '龍虎和', 'opt_lh', '10', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '前三', 'opt_q3', '11', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '中三', 'opt_z3', '12', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '1', '后三', 'opt_h3', '13', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '冠军', 'opt_1', '1', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '亞軍', 'opt_2', '2', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第三名', 'opt_3', '3', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第四名', 'opt_4', '4', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第五名', 'opt_5', '5', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第六名', 'opt_6', '6', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第七名', 'opt_7', '7', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第八名', 'opt_8', '8', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第九名', 'opt_9', '9', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '第十名', 'opt_10', '10', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '1-10大小', 'opt_dx', '11', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '1-10單雙', 'opt_ds', '12', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '1-5龍虎', 'opt_lh', '13', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '冠、亞軍和', 'opt_gyh', '14', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '冠亞和大小', 'opt_gyhdx', '15', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '3', '冠亞和單雙', 'opt_gyhds', '16', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '冠军', 'opt_1', '1', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '亞軍', 'opt_2', '2', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第三名', 'opt_3', '3', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第四名', 'opt_4', '4', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第五名', 'opt_5', '5', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第六名', 'opt_6', '6', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第七名', 'opt_7', '7', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第八名', 'opt_8', '8', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第九名', 'opt_9', '9', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '第十名', 'opt_10', '10', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '1-10大小', 'opt_dx', '11', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '1-10單雙', 'opt_ds', '12', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '1-5龍虎', 'opt_lh', '13', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '冠、亞軍和', 'opt_gyh', '14', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '冠亞和大小', 'opt_gyhdx', '15', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '4', '冠亞和單雙', 'opt_gyhds', '16', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '冠军', 'opt_1', '1', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '亞軍', 'opt_2', '2', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第三名', 'opt_3', '3', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第四名', 'opt_4', '4', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第五名', 'opt_5', '5', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第六名', 'opt_6', '6', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第七名', 'opt_7', '7', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第八名', 'opt_8', '8', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第九名', 'opt_9', '9', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '第十名', 'opt_10', '10', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '1-10大小', 'opt_dx', '11', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '1-10單雙', 'opt_ds', '12', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '1-5龍虎', 'opt_lh', '13', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '冠、亞軍和', 'opt_gyh', '14', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '冠亞和大小', 'opt_gyhdx', '15', '0.000', '0.000','special');
        INSERT INTO `game_options` VALUES (null, '5', '冠亞和單雙', 'opt_gyhds', '16', '0.000', '0.000','special');
         */
        /**
         *
         *
        -- ----------------------------
        -- Records of game_groups
        -- ----------------------------
        INSERT INTO `game_groups` VALUES (NULL, '1', '兩面盤', 'grp_sm', '1', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '單球1-5', 'grp_dq', '2', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '第一球', 'grp_1', '3', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '第二球', 'grp_2', '4', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '第三球', 'grp_3', '5', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '第四球', 'grp_4', '6', '1');
        INSERT INTO `game_groups` VALUES (NULL, '1', '第五球', 'grp_5', '7', '1');
        INSERT INTO `game_groups` VALUES (NULL, '2', '兩面盤', 'grp_sm', '1', '1');
        INSERT INTO `game_groups` VALUES (NULL, '2', '单球1-10', 'grp_dq', '2', '1');
        INSERT INTO `game_groups` VALUES (NULL, '2', '冠、亞軍 組合', 'grp_gy', '3', '1');
        INSERT INTO `game_groups` VALUES (NULL, '2', '三、四、五、六名', 'grp_3456', '4', '1');
        INSERT INTO `game_groups` VALUES (NULL, '2', '七、八、九、十名', 'grp_78910', '5', '1');
        INSERT INTO `game_groups` VALUES (NULL, '3', '兩面盤', 'grp_sm', '1', '1');
        INSERT INTO `game_groups` VALUES (NULL, '3', '單球1-10', 'grp_dq', '2', '1');
        INSERT INTO `game_groups` VALUES (NULL, '3', '冠、亞軍 組合', 'grp_gy', '3', '1');
        INSERT INTO `game_groups` VALUES (NULL, '3', '三、四、五、六名', 'grp_3456', '4', '1');
        INSERT INTO `game_groups` VALUES (NULL, '3', '七、八、九、十名', 'grp_78910', '5', '1');
        INSERT INTO `game_groups` VALUES (NULL, '4', '兩面盤', 'grp_sm', '1', '1');
        INSERT INTO `game_groups` VALUES (NULL, '4', '單球1-10', 'grp_dq', '2', '1');
        INSERT INTO `game_groups` VALUES (NULL, '4', '冠、亞軍 組合', 'grp_gy', '3', '1');
        INSERT INTO `game_groups` VALUES (NULL, '4', '三、四、五、六名', 'grp_3456', '4', '1');
        INSERT INTO `game_groups` VALUES (NULL, '4', '七、八、九、十名', 'grp_78910', '5', '1');
        INSERT INTO `game_groups` VALUES (NULL, '5', '兩面盤', 'grp_sm', '1', '1');
        INSERT INTO `game_groups` VALUES (NULL, '5', '單球1-10', 'grp_dq', '2', '1');
        INSERT INTO `game_groups` VALUES (NULL, '5', '冠、亞軍 組合', 'grp_gy', '3', '1');
        INSERT INTO `game_groups` VALUES (NULL, '5', '三、四、五、六名', 'grp_3456', '4', '1');
        INSERT INTO `game_groups` VALUES (NULL, '5', '七、八、九、十名', 'grp_78910', '5', '1');
         */
        /**
         *
        -- ----------------------------
        -- Records of game_bets
        -- ----------------------------
        INSERT INTO `game_bets` VALUES (NULL, '1', '0', 'bet_0', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '1', 'bet_1', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '2', 'bet_2', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '3', 'bet_3', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '4', 'bet_4', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '5', 'bet_5', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '6', 'bet_6', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '7', 'bet_7', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '8', 'bet_8', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '9', 'bet_9', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '大', 'bet_da', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '小', 'bet_x', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '單', 'bet_d', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '雙', 'bet_s', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '總和大', 'bet_zhd', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '總和小', 'bet_zhx', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '總和單', 'bet_zhda', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '總和雙', 'bet_zhs', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '龍', 'bet_long', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '虎', 'bet_hu', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '和', 'bet_he', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '豹子', 'bet_bz', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '順子', 'bet_sz', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '對子', 'bet_dz', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '半順', 'bet_bs', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (NULL, '1', '雜六', 'bet_zl', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '1', 'bet_1', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '2', 'bet_2', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '3', 'bet_3', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '4', 'bet_4', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '5', 'bet_5', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '6', 'bet_6', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '7', 'bet_7', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '8', 'bet_8', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '9', 'bet_9', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '10', 'bet_10', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '11', 'bet_11', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '12', 'bet_12', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '13', 'bet_13', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '14', 'bet_14', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '15', 'bet_15', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '16', 'bet_16', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '17', 'bet_17', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '18', 'bet_18', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '19', 'bet_19', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '大', 'bet_da', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '小', 'bet_x', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '單', 'bet_d', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '雙', 'bet_s', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '冠、亞大', 'bet_zhd', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '冠、亞小', 'bet_zhx', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '冠、亞單', 'bet_zhda', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '冠、亞雙', 'bet_zhs', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '龍', 'bet_long', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '虎', 'bet_hu', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '3', '和', 'bet_he', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '1', 'bet_1', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '2', 'bet_2', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '3', 'bet_3', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '4', 'bet_4', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '5', 'bet_5', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '6', 'bet_6', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '7', 'bet_7', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '8', 'bet_8', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '9', 'bet_9', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '10', 'bet_10', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '11', 'bet_11', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '12', 'bet_12', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '13', 'bet_13', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '14', 'bet_14', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '15', 'bet_15', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '16', 'bet_16', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '17', 'bet_17', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '18', 'bet_18', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '19', 'bet_19', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '大', 'bet_da', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '小', 'bet_x', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '單', 'bet_d', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '雙', 'bet_s', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '冠、亞大', 'bet_zhd', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '冠、亞小', 'bet_zhx', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '冠、亞單', 'bet_zhda', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '冠、亞雙', 'bet_zhs', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '龍', 'bet_long', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '虎', 'bet_hu', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '4', '和', 'bet_he', '', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '1', 'bet_1', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '2', 'bet_2', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '3', 'bet_3', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '4', 'bet_4', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '5', 'bet_5', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '6', 'bet_6', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '7', 'bet_7', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '8', 'bet_8', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '9', 'bet_9', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '10', 'bet_10', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '11', 'bet_11', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '12', 'bet_12', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '13', 'bet_13', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '14', 'bet_14', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '15', 'bet_15', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '16', 'bet_16', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '17', 'bet_17', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '18', 'bet_18', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '19', 'bet_19', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '大', 'bet_da', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '小', 'bet_x', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '單', 'bet_d', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '雙', 'bet_s', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '冠、亞大', 'bet_zhd', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '冠、亞小', 'bet_zhx', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '冠、亞單', 'bet_zhda', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '冠、亞雙', 'bet_zhs', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '龍', 'bet_long', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '虎', 'bet_hu', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '2', '和', 'bet_he', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '0', 'bet_0', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '1', 'bet_1', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '2', 'bet_2', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '3', 'bet_3', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '4', 'bet_4', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '5', 'bet_5', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '6', 'bet_6', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '7', 'bet_7', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '8', 'bet_8', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '9', 'bet_9', 'ball-num', '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '大', 'bet_da', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '小', 'bet_x', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '單', 'bet_d', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '雙', 'bet_s', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '總和大', 'bet_zhd', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '總和小', 'bet_zhx', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '總和單', 'bet_zhda', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '總和雙', 'bet_zhs', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '龍', 'bet_long', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '虎', 'bet_hu', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '和', 'bet_he', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '豹子', 'bet_bz', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '順子', 'bet_sz', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '對子', 'bet_dz', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '半順', 'bet_bs', null, '1',  '1');
        INSERT INTO `game_bets` VALUES (null, '5', '雜六', 'bet_zl', null, '1',  '1');
         */
    }
}
