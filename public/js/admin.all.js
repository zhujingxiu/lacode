function math_add(a, b) {
    var c, d, e;
    try {
        c = a.toString().split(".")[1].length;
    } catch (f) {
        c = 0;
    }
    try {
        d = b.toString().split(".")[1].length;
    } catch (f) {
        d = 0;
    }
    return e = Math.pow(10, Math.max(c, d)), (math_mul(a, e) + math_mul(b, e)) / e;
}

function math_sub(a, b) {
    var c, d, e;
    try {
        c = a.toString().split(".")[1].length;
    } catch (f) {
        c = 0;
    }
    try {
        d = b.toString().split(".")[1].length;
    } catch (f) {
        d = 0;
    }
    return e = Math.pow(10, Math.max(c, d)), (math_mul(a, e) - math_mul(b, e)) / e;
}

function math_mul(a, b) {
    var c = 0,
        d = a.toString(),
        e = b.toString();
    try {
        c += d.split(".")[1].length;
    } catch (f) {
    }
    try {
        c += e.split(".")[1].length;
    } catch (f) {
    }
    return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
}

function math_div(a, b) {
    var c, d, e = 0,
        f = 0;
    try {
        e = a.toString().split(".")[1].length;
    } catch (g) {
    }
    try {
        f = b.toString().split(".")[1].length;
    } catch (g) {
    }
    return c = Number(a.toString().replace(".", "")), d = Number(b.toString().replace(".", "")), math_mul(c / d, Math.pow(10, f - e));
}

function to_upcase(value) {
//var whole = document.all.Money_XY_1.value;
    //var whole = document.getElementById(id).value;
    var whole = value;//document.getElementById(id).value;

//分离整数与小数
    var num;
    var dig;
    if (whole.indexOf(".") == -1) {
        num = whole;
        dig = "";
    }
    else {
        num = whole.substr(0, whole.indexOf("."));
        dig = whole.substr(whole.indexOf(".") + 1, whole.length);
    }

//转换整数部分
    var i = 1;
    var len = num.length;

    var dw2 = new Array("", "萬", "億");//大单位
    var dw1 = new Array("十", "百", "千");//小单位
    var dw = new Array("", "一", "二", "三", "四", "五", "六", "七", "八", "九");//整数部分用
    var k1 = 0;//计小单位
    var k2 = 0;//计大单位
    var str = "";

    for (i = 1; i <= len; i++) {
        var n = num.charAt(len - i);
        if (n == "0") {
            if (k1 != 0)
                str = str.substr(1, str.length - 1);
        }

        str = dw[Number(n)].concat(str);//加数字
        //在数字范围内
        if (len - i - 1 >= 0) {
            //加小单位
            if (k1 != 3) {
                str = dw1[k1].concat(str);
                k1++;
            }
            else {
                //不加小单位，加大单位
                k1 = 0;
                var temp = str.charAt(0);
                if (temp == "萬" || temp == "億")//若大单位前没有数字则舍去大单位
                    str = str.substr(1, str.length - 1);
                str = dw2[k2].concat(str);
            }
        }
        //小单位到千则大单位进一
        if (k1 == 3) {
            k2++;
        }

    }
    if (str.length >= 2) {
        if (str.substr(0, 2) == "一十") str = str.substr(1, str.length - 1);
    }
    return str;
}

//身份证号码的验证规则
function isIdCardNo(num) {
    //if (isNaN(num)) {alert("输入的不是数字！"); return false;}
    var len = num.length, re;
    // 香港澳门
    if (len == 10 || len == 11)
        re = new RegExp(/^([157A-Z]{1,2})([0-9]{6})\([A0-9]\)$/);
    else if (len == 15)
        re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{2})(\w)$/);
    else if (len == 18)
        re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/);
    else
        return false;

    var a = num.match(re);
    if (a != null && (len == 15 || len == 18)) {
        if (len == 15) {
            var D = new Date("19" + a[3] + "/" + a[4] + "/" + a[5]);
            var B = D.getYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
        } else if (len == 18) {
            var D = new Date(a[3] + "/" + a[4] + "/" + a[5]);
            var B = D.getFullYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
        }
        if (!B)
            return false;
    }
    if (!re.test(num))
        return false;

    return true;
}

//车牌号校验
function isPlateNo(plateNo) {
    var re = /^[\u4e00-\u9fa5]{1}[A-Z]{1}[A-Z_0-9]{5}$/;
    if (re.test(plateNo)) {
        return true;
    }
    return false;
}


$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //admin theme
    $(document).delegate('[data-tip-upcase]', "input propertychange blur", function () {
        var tip_rel = $(this).data('tip-upcase');
        var tip_text = to_upcase($(this).val());
        $(tip_rel).html('<p class="text-success">' + tip_text + '</p>');
    });

    $('.inputFocus').attr('autocomplete','off');
})
