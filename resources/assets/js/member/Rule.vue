<template>
    <div style="width: 1200px;margin-left:10px">
        <select id="lt" onchange="selects(this)" style="margin-top:11px;margin-left:14px;">
            <option value="2">重慶時時彩</option>
            <option selected="selected" value="3">極速時時彩</option>
            <option value="6">北京赛车PK10</option>
            <option value="4">幸运飞艇</option>
        </select>
        <h2>重要聲明</h2>
        <ol>
            <li>1.如果客戶懷疑自己的資料被盜用，應立即通知本公司，並更改詳細數據，以前的使用者名稱及密碼將全部無效。</li>
            <li>2.客戶有責任確保自己的賬戶及登入資料的保密性。以使用者名稱及密碼進行的任何網上投註將被視為有效。 </li>
            <li>3.公布賠率時出現的任何打字錯誤或非故意人為失誤，本公司保留改正錯誤和按正確賠率結算投註的權力。您居住所在地的法律有可能規定網絡博弈不合法；若此情況屬實，本公司將不會批準您使用付賬卡進行交易。 </li>
            <li>4.每次登入時客戶都應該核對自己的賬戶結余額。如對余額有任何疑問，請在第壹時間內通知本公司。</li>
            <li>5.壹旦投註被接受，則不得取消或修改。</li>
            <li>6.所有號碼賠率將不時浮動，派彩時的賠率將以確認投註時之賠率為準。</li>
            <li>7.每註最高投註金額按不同[場次]及[投註項目]及[會員賬號]設定浮動。如投註金額超過上述設定，本公司有權取消超過之投註金額。</li>
            <li>8.所有投註都必須在開獎前時間內進行否則投註無效。</li>
            <li>9.所有投註派彩彩金皆含本金。</li>
        </ol>
        <h2>全天五分彩規則說明</h2>
        <ul>
            <li>該遊戲的投註時間、開獎時間和開獎號碼與全天五分彩完全同步（<a class="label" href="http://1680180.com/Lottery/10011" target="_blank">開獎網</a>），北京時間（GMT+8）每天從上午10：00開到晚上23：00，每10分鐘開壹次獎，每天開獎84期。</li>
            <li>具體遊戲規則如下:</li>
        </ul>
        <ul>
            <li><span class="label">1.第壹球~第五球</span></li>
            <li class="stress"><span class="label">第壹球特~第五球特：</span>第壹球特、第二球特、第三球特、第四球特、第五球特：指下註的每壹球特與開出之號碼其開獎順序及開獎號碼相同，視為中獎，如第壹球開出號碼8，下註第壹球為8者視為中獎，其余情形視為不中獎。</li>
            <li class="stress"><span class="label">單雙大小：</span>根據相應單項投註第壹球特 ~ 第五球特開出的球號，判斷勝負。</li>
            <li class="stress"><span class="label">大小：</span>根據相應單項投註的第壹球特 ~ 第五球特開出的球號大於或等於5為特碼大，小於或等於4為特碼小。</li>
            <li class="stress"><span class="label">單雙：</span>根據相應單項投註的第壹球特 ~ 第五球特開出的球號為雙數叫特雙，如2、6；特碼為單數叫特單，如1、3。</li>
        </ul>
        <ul>
            <li><span class="label">2.總和單雙大小：</span></li>
            <li class="stress"><span class="label">大小：</span>根據相應單項投註的第壹球特 ~ 第五球特開出的球號大於或等於23為特碼大，小於或等於22為特碼小。</li>
            <li class="stress"><span class="label">單雙：</span>根據相應單項投註的第壹球特 ~ 第五球特開出的球號數字總和值是雙數為總和雙，數字總和值是單數為總和單。</li>
        </ul>
        <ul>
            <li><span class="label">3.前三特殊玩法： 豹子 &gt; 順子 &gt; 對子 &gt; 半順 &gt; 雜六 。</span></li>
            <li class="stress"><span class="label">豹子：</span>中獎號碼的個位十位百位數字都相同。----如中獎號碼為000、111、999等，中獎號碼的個位十位百位數字相同，則投註豹子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">順子：</span>中獎號碼的個位十位百位數字都相連，不分順序。（數字9、0、1相連）----如中獎號碼為123、901、321、546等，中獎號碼個位十位百位數字相連，則投註順子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">對子：</span>中獎號碼的個位十位百位任意兩位數字相同。（不包括豹子）----如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。如果開獎號碼為豹子,則對子視為不中獎。如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">半順：</span>中獎號碼的個位十位百位任意兩位數字相連，不分順序。（不包括順子、對子。）----如中獎號碼為125、540、390、706，中獎號碼有兩位數字相連，則投註半順者視為中獎，其它視為不中獎。如果開獎號碼為順子、對子,則半順視為不中獎。--如中獎號碼為123、901、556、233，視為不中獎。</li>
            <li class="stress"><span class="label">雜六：</span>不包括豹子、對子、順子、半順的所有中獎號碼。----如中獎號碼為157，中獎號碼位數之間無關聯性，則投註雜六者視為中獎，其它視為不中獎。</li>
        </ul>
        <ul>
            <li><span class="label">4.中三特殊玩法： 豹子 &gt; 順子 &gt; 對子 &gt; 半順 &gt; 雜六 。</span></li>
            <li class="stress"><span class="label">豹子：</span>中獎號碼的十位百位千位數字都相同。----如中獎號碼為000、111、999等，中獎號碼的十位百位千位數字相同，則投註豹子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">順子：</span>中獎號碼的十位百位千位數字都相連，不分順序。（數字9、0、1相連）----如中獎號碼為123、901、321、546等，中獎號碼十位百位千位數字相連，則投註順子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">對子：</span>中獎號碼的十位百位千位任意兩位數字相同。（不包括豹子）----如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。如果開獎號碼為豹子,則對子視為不中獎。如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">半順：</span>中獎號碼的十位百位千位任意兩位數字相連，不分順序。（不包括順子、對子。）----如中獎號碼為125、540、390、706，中獎號碼有兩位數字相連，則投註半順者視為中獎，其它視為不中獎。如果開獎號碼為順子、對子,則半順視為不中獎。--如中獎號碼為123、901、556、233，視為不中獎。</li>
            <li class="stress"><span class="label">雜六：</span>不包括豹子、對子、順子、半順的所有中獎號碼。----如中獎號碼為157，中獎號碼位數之間無關聯性，則投註雜六者視為中獎，其它視為不中獎。</li>
        </ul>
        <ul>
            <li><span class="label">6.後三特殊玩法： 豹子 &gt; 順子 &gt; 對子 &gt; 半順 &gt; 雜六 。</span></li>
            <li class="stress"><span class="label">豹子：</span>中獎號碼的百位千位萬位數字都相同。----如中獎號碼為000、111、999等，中獎號碼的百位千位萬位數字相同，則投註豹子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">順子：</span>中獎號碼的百位千位萬位數字都相連，不分順序。（數字9、0、1相連）----如中獎號碼為123、901、321、546等，中獎號碼百位千位萬位數字相連，則投註順子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">對子：</span>中獎號碼的百位千位萬位任意兩位數字相同。（不包括豹子）----如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。如果開獎號碼為豹子,則對子視為不中獎。如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。</li>
            <li class="stress"><span class="label">半順：</span>中獎號碼的百位千位萬位任意兩位數字相連，不分順序。（不包括順子、對子。）----如中獎號碼為125、540、390、706，中獎號碼有兩位數字相連，則投註半順者視為中獎，其它視為不中獎。如果開獎號碼為順子、對子,則半順視為不中獎。--如中獎號碼為123、901、556、233，視為不中獎。</li>
            <li class="stress"><span class="label">雜六：</span>不包括豹子、對子、順子、半順的所有中獎號碼。----如中獎號碼為157，中獎號碼位數之間無關聯性，則投註雜六者視為中獎，其它視為不中獎。</li>
        </ul>
        <ul>
            <li><span class="label">7.龍虎和特殊玩法： 龍 &gt; 虎 &gt; 和 （0為最小，9為最大）。</span></li>
            <li class="stress"><span class="label"> 龍：</span>開出之號碼第壹球（萬位）的中獎號碼大於第五球（個位）的中獎號碼，如出和局為打和。如 第壹球開出4 第五球開出2；第壹球開出9 第五球開出8；第壹球開出5 第五球開出1...中獎為龍。</li>
            <li class="stress"><span class="label"> 虎：</span>開出之號碼第壹球（萬位）的中獎號碼小於第五球（個位）的中獎號碼，如出和局為打和。如 第壹球開出7 第五球開出9；第壹球開出3 第五球開出5；第壹球開出5 第五球開出8...中獎為虎。</li>
            <li class="stress"><span class="label"> 和：</span>開出之號碼第壹球（萬位）的中獎號碼等於第五球（個位）的中獎號碼，例如開出結果：2***2則投註和局者視為中獎，其它視為不中獎。</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "Rule"
    }
</script>

<style scoped>

</style>