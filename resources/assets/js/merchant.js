
$(function() {
    $(document).pjax('a[data-pjax]', '#pjax-container');
    $.pjax.defaults.timeout=1200;
    $(document).on("pjax:timeout", function(event) {
        // 阻止超时导致链接跳转事件发生
        event.preventDefault()
    });
    $('.navOne-new').on('mouseover',function () {
        $(this).parent().find('.navOne-newDown > div').show();
    });
    $('#navBtnMenu > li > a').click(function () {
        $('.menu-children').css('display','none');
        $('#navBtnMenu > li').removeClass('active');
        $(this).parent().addClass('active');
    });
    $('.pullMenu').click(function () {
        var _menu = $(this).data('menu');
        $('.menu-children').css('display','none');
        $('#menu-children-'+_menu).css('display','block');
        $('#navBtnMenu > li').removeClass('active');
    });
    $('.pullGroup').click(function () {
        var _group = $(this).data('group');
        $('.menu-children').css('display','none');
        $('#group-children-'+_group).css('display','block');
        $('#navBtnMenu > li').removeClass('active');
        $('#currentType').text($(this).children('a').text());
        $('.navOne-newDown > div').hide();
    });

    $('.filterSubmit').click(function () {
        var _url = $(this).parentsUntil('filterForm').parent('form').attr('action');
        filterList(_url);
    });
    $('td.inputOnMouse').delegate('input[type="text"]','focus',function () {
        $(this).attr('class','inp1mMM');
    });
    $('td.inputOnMouse').delegate('input[type="text"]','blur',function () {
        $(this).attr('class','inp1MM');
    });
    $('.toUpcase').delegate('input[type="text"]','keyup,blur',function () {
        var _value = $(this).val();
        if($.isNumeric(_value) && _value >0)
        $(this).parent().find('.showUpcase').text(to_upcase(_value));
    });

});
function pjax_redirect(url) {
    $('#pjax-hide-link').remove();
    $('#footer').append('<a id="pjax-hide-link" style="display: none" data-pjax="true" href="'+url+'"></a>')
    $('#pjax-hide-link').trigger('click');
}
function filterList(url) {
    var paramArr=[];
    $(".filterForm .filterItem").each(function(){
        if($(this).val()&&$(this).val()!='*'){
            paramArr.push($(this).attr("name")+"="+encodeURIComponent($(this).val()))
        }
    });
    if(paramArr.length>0){
        url+= (url.indexOf("?") == -1 ? "?":"&")+paramArr.join("&");
    }
    pjax_redirect(url);
}