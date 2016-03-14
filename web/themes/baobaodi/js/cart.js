var $btm=$('#cashier_part');
var _btmheight=$btm.height();
var winH=$(window).height();
var _btmtop=$btm.position().top;
var warehouse_id = 0;
var popNotShow = 0;
$(document).ready(function(){
    //弹层 关税提示
    var cartpop = {
        init: function(){
            this.$mask = $('.popBg');
            this.$shui = $('.popShui');
        },
        show: function(){
            this.$mask.show();
            var iW = this.$shui.width();
            var iH = this.$shui.height();
            this.$shui.css({
                'margin-top': -iH/2 + 'px',
                'margin-left': -iW/2 + 'px'
            }).show();
        },
        hide: function(){
            this.$mask.hide();
            this.$shui.hide();
        }
    };
    cartpop.init();
    $tipsDelay = 5500;
    _min=1;
    _max=99;
    //$('.cashier_part').delegate('.btnJieSuan','click',function(e){
    //    warehouse_id = $(this).attr('data-warehouse');
    //    if($('#taxes_price_'+warehouse_id).length) {
    //        taxes_price = parseFloat($('#taxes_price_'+warehouse_id).text().replace('¥',''));
    //        if(taxes_price > 50 && popNotShow != warehouse_id) {
    //            popNotShow = warehouse_id;
    //            cartpop.$shui.on('click', '.icon-off, .btn1', function(e) {
    //                popNotShow = 0;
    //                e.preventDefault();
    //                cartpop.hide();
    //
    //            }).on('click', '.btn2', function(e) {
    //                e.preventDefault();
    //                cartpop.hide();
    //                $('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').trigger('click');
    //            });
    //            cartpop.show();
    //            return;
    //        }
    //    }
    //    formSubmit(e);
    //    e.preventDefault();
    //});
    //赠品选择
    $('body').delegate('#shopping_cart .selectBonus', 'click', function(event) {
        event.preventDefault();
        var html;
        var _this = $(this);
        var _data = {
            pid:_this.closest('.cl_tit').data('promotion'),
            warehouse_id:_this.parents('.c_list').attr('data-warehouse_id')
        };
        /*if (_this.closest('p').data('rowid')) {
            _data.rowid = _this.closest('p').data('rowid')
        };*/
        $.ajax({
            url: '/instant/cart/getGifts',
            type: 'POST',
            dataType: 'json',
            data: _data,
            success:function(data){
                if (data.code == 1) {
                    html = '<div id="popWin" class="bounsPop">'
                    +'<div class="bounslist" style="height: 230px;overflow-y: auto;">'
                    +   '<table>'
                            +'<tbody>';
                        for (var i = 0; i < data.bouns.length; i++) {
                            if(data.bouns[i]['status'] == 1) {
                                html +='<tr>'
                                +        '<td class="ck"><input type="radio" name="gifts_'+ data.bouns[i].pid +'" value="'+ data.bouns[i].sku +'"></td>'
                                +        '<td class="img"><img src="'+ data.bouns[i].img +'" alt=""></td>'
                                +        '<td><p>'+ data.bouns[i].name +'<br>'+ data.bouns[i].num +' 件</p></td>'
                                +    '</tr>'
                            }
                        };
                        html +='</tbody>'
                        +   '</table>'
                        + '</div>'
                        +'<div class="opline"><a href="#" class="okdiabled" data-pid="'+ data.bouns[0].pid +'" data-rowid="'+data.bouns[0].rowid+'" data-warehouse_id="'+data.warehouse_id+'">确定</a><a href="#" class="cancel">取消</a></div>'
                    +'</div>';
                    $("#dialog").html(html);
                    $("#dialog").dialog({
                        autoOpen:true,
                        closeOnEscape:true,
                        modal:true,
                        width:450 ,
                        draggable:false,
                        resizable:false,
                        position:'center'
                    }).dialog("open");
                }else{
                    cartTips(event,'err',data.msg)
                }
            }
        })
    })
    //赠品浮层 赠品选择
    $('body').delegate('.bounsPop input[type="radio"]', 'click', function(event) {
        $('.bounsPop .okdiabled').removeClass('okdiabled').addClass('ok');
    });
    $('body').delegate('.bounsPop .okdiabled', 'click', function(event) {
        event.preventDefault();
        //console.log(1)
        cartTips(event,'err','请选择赠品')
    })
    // 赠品浮层 确定
    $('body').delegate('.bounsPop .ok', 'click', function(event) {
        event.preventDefault();
        var _this = $(this);
        var _data = {
            pid : _this.data('pid'),
            product: $('.bounsPop input[type="radio"]:checked').val(),
            row_id : _this.data('rowid'),
            warehouse_id:_this.data('warehouse_id')
        };

        $.ajax({
            url: '/instant/cart/chooseGift',
            type: 'POST',
            dataType: 'json',
            data: _data,
            success:function(data){
               if (data.code == 1) {
                        w_p = $('#shopping_cart .cl_tit[data-promotion="'+data.pid+'"]');
                        w_p.find('.cl_words > .selectBonus').hide();
                        if(w_p.find('.cl_words_zp').length) {
                            w_p.find('.cl_words_zp').html('<em>[赠品]</em>'+data.gift_name+'<a href="javascript:void(0)" class="cart_zp_btn btn_xzzp selectBonus">重新选择</a>');
                        } else {
                            zp = '<span class="cl_words_zp" >';
                            zp += '<em>[赠品]</em>'+data.gift_name;
                            zp += '<a class="cart_zp_btn btn_xzzp selectBonus" href="javascript:void(0)">重新选择</a>';
                            zp += '</span>';
                            w_p.find('.cl_words').append(zp);
                        }
                    $('#dialog').dialog('close');
               }else{
                 cartTips(event,'err',data.msg)
               }
            }
        })
        
    });
    $('body').delegate('.bounsPop .cancel', 'click', function(event) {
        event.preventDefault();
        $('#dialog').dialog('close');
    });
    //更改优惠活动 
        //展示浮层
    //$('#shopping_cart .msctab .modity').click(function(event) {
    $('#shopping_cart .modity').click(function(event) {
        event.preventDefault();
        var posY = $(event.target).offset().top + 27, posX = $(event.target).offset().left - 264,html;
        var _this = $(this);
        var row = _this.closest('tr');
        //var row_id = row.find('.productcheck').eq(0).val();
        var row_id = _this.closest('.gooditem').find('.mck').val();
            //opid = target.closest('tbody').data('pid');
        var _data = {
            row_id:row_id
        };
        //if (_this.closest('tbody').data('pid')) {
        if (_this.closest('.cl_con').data('pid')) {
            //_data.opid=_this.closest('tbody').data('pid')
            _data.opid=_this.closest('.cl_con').data('pid')
        }else{
            _data.opid=0
        }
        $.ajax({
          url: '/instant/cart/getPromotions',
          type: 'POST',
          dataType: 'json',
          data: _data,
          success: function(data) {
                if (data.code == 1) {
                    var html = '<span class="arr"></span><div class="conn">'
                    +'<p class="promotionP"><b>活动优惠：</b><select name="promotionSelector" id="promotionSelector">';
                    for (var i = 0; i < data.data.length; i++) {
                        if (data.data[i].id == _data.opid) {
                            html += '<option selected value="'+ data.data[i].id +'">'+ data.data[i].title +'</option>';
                        }else{
                            html += '<option value="'+ data.data[i].id +'">'+ data.data[i].title +'</option>';
                        }
                    };
                    html += '</select></p></div><div class="opline"><a href="#" class="ok" data-opid="'+ _data.opid +'" data-rowid="'+ _data.row_id +'" >确定</a><a href="#" class="cancel">取消</a></div>'
                    $('#promotionLists').show().css({
                        top: posY,
                        left: posX
                    }).show().empty().html(html);
                }else{
                     cartTips(event,'err',data.msg)
                }

          }
        })
    });
        //修改优惠id
    $('body').delegate('#promotionLists .ok', 'click', function(event) {
        event.preventDefault();
        var _this = $(this);
        var _data = {
            pid:$('#promotionSelector').val(),
            row_id:_this.data('rowid'),
            opid:_this.data('opid')
        }
        if (_data.pid != _data.opid) {
            jQuery.ajax({
                url: '/instant/cart/getPromotionInfoByParams',
                type: 'POST',
                dataType: 'json',
                data: _data,
                success: function(data) {
                //called when successful
                /*{
                    pid:,
                    active:,
                    gift:,
                }*/
                //显示新活动
                    if (data.code == 1) {
                        return window.location.reload();
                        var info = {
                            pid:data.pid,
                            pname:data.pname,
                            opid:_data.opid,
                            active:data.active,
                            type:data.gift,
                            rowid:_data.row_id,
                            gift:data.gift,
                            diff:data.diff
                        };
                        var html;
                        var otr = $('input[name="productcheck"]').filter('[value="'+ _data.row_id +'"]').closest('.gooditem');
                        if (data.pid != 0) {
                            if ($('.cl_con[data-pid='+ data.pid +']').length>0) {
                                var b = otr.clone(true);
                                $('.cl_con[data-pid='+ data.pid +']').find('.cl_items').append(b);
                                
                            }else{
                                $('.cl_con[data-pid='+ info.pid +']').find('.cl_tit').remove();
                                b=otr.clone(true);
                                html = '<div class="cl_con" data-pid="'+info.pid+'">';
                                html += '<div class="cl_tit">';
                                html += '<div class="cl_mck"><input class="mck" type="checkbox" value="0"';
                                if($('.cl_con[data-pid='+ info.opid +']').find('.cl_mck .mck').prop('checked')) {
                                    html += ' checked ';    
                                }
                                html += '></div>';
                                html += '<div class="cl_tag"><span>'+data.ptag+'</span></div>';
                                html += '<div class="cl_words">'+data.pname+'</span></div>';
                                html += '</div>';

                                html += '<div class="cl_items"></div></div>';
                               //html = '<thead class="cellthead" data-pid="'+ data.pid +'"><tr><td colspan="6"><span class="promico">'+ data.ptag +'</span> <span class="txt">'+ data.pname +'</span></td></tr></thead><tbody data-pid="'+ data.pid +'"></tbody>';
                               $('.c_list').append(html);
                               $('.cl_con[data-pid='+ data.pid +']').find('.cl_items').append(b);
                               //$('.cl_con[data-pid='+ data.pid +']').append(b);
                            }
                        }else{
                            var b = otr.clone(true);
                            if ($('.cl_con[data-pid='+ info.pid +']').find('.gooditem').length < 1) { //原活动无商品
                                html = '<div class="cl_con" data-pid="'+info.pid+'">';
                                html += '<div class="cl_tit">';
                                html += '<div class="cl_mck"><input class="mck" type="checkbox" value="0"';
                                if($('.cl_con[data-pid='+ info.opid +']').find('.cl_mck .mck').prop('checked')) {
                                    html += ' checked ';    
                                }
                                html += '></div>';
                                html += '<div class="cl_words"><span>1</span>件商品</div>';
                                html += '</div>';

                                html += '<div class="cl_items"></div></div>';
                                $('.c_list').append(html);
                            }
                            $('.cl_con[data-pid='+ info.pid +']').find('.cl_items').append(b);
                            otr.remove();
                        }
                        var arr = {
                            row_id:_data.row_id,
                            num:Math.abs($('input[name="productcheck"][value="'+ _data.row_id +'"]').closest('.gooditem').find('.dp_num').val()),
                            opid:data.pid
                        }
                        // if (!_this.closest('tbody').data('pid')) {
                        //     pro.opid = 0
                        // }
                        event.target = $(event.target).parent('.num_box');
                        
                        otr.remove();

                        if ($('.cl_con[data-pid='+ info.opid +']').find('.gooditem').length == 0) { //如果老活动内商品为空删除thead
                            $('.cl_con[data-pid='+ info.opid +']').remove();
                            
                            changeTotal(event);
                        }else{
                            changePromotion(info,event);
                        }
                        
                        changeNum($('input[name="productcheck"][value="'+ arr.row_id +'"]').closest('.gooditem').find('.dp_num'),arr);
                        addPromotionInfo(info);
                        $('#promotionLists').hide();
                    }else{
                         cartTips(event,'err',data.msg)
                    }
                }
            });
        }else{
            $('#promotionLists').hide();
        }
    });
    $('body').delegate('#promotionLists .cancel', 'click', function(event) {
        event.preventDefault();
        $('#promotionLists').hide()
    });
    //20150715加入
   
    changeBtmFixed();
    $(window).on('scroll',function(){
        changeBtmFixed();
    });   
    $('#shopping_cart .delete').confirm({
        msg:'确定要删除该商品么？',
        modal:true,
        onOK:function(e){
            var target = $(e.target)
            var _row_id = [];
            //_row_id[0] = target.closest('tr').find('input[name="productcheck"]').val();
            _row_id[0] = target.closest('.gooditem').find('.mck').val();
            //opid = target.closest('tbody').data('pid');
            opid = target.closest('.cl_con').data('pid')
            var sugs = {
                target:e,
                rowid:_row_id,
                opid:opid
            }
            partDelete(sugs);
        },
        onCancel:function(){
        }
    });
    
    // $('#shopping_cart').delegate('.delete','click',function(e){
        // e.preventDefault();
        // _this = 
    // });
    $('#shopping_cart .dp_jia').click(function(event) {
        event.preventDefault();
        var _this = $(this);
        //var numInp = _this.closest('.num_box').find('.shopping_num');
        var numInp = _this.closest('.it_num').find('.dp_num');
        var num = Math.abs(parseInt(numInp.val()));
        num++;
        count = 1;
        if(num > 99) {
            cartTips(event,'err','商品数量必须大于1同时小于99');
            return true;
        }
        //var rowid = _this.closest('tr').find('.productcheck').val();
        var rowid = _this.closest('.gooditem').find('.it_mck .mck').attr('cart-sku');
        var warehouse_id = numInp.attr('warehouse_id');
        var size = _this.closest('.gooditem').find('.it_size').text();
        if(!size) {
            size = 'SINGLE';
        }
        var pro = {
            id:rowid,
            count:count,
            num:num,
            size:size,
            //opid:_this.closest('tbody').data('pid')
            warehouse_id:parseInt(warehouse_id),
            opid:_this.closest('.cl_con').data('pid')
        }
        //if (!_this.closest('tbody').data('pid')) {
        if (!_this.closest('.cl_con').data('pid')) {
            pro.opid = 0
        }
        
        changeNum(numInp,pro,event)
    });
    //商品数量减少
    $('#shopping_cart #cart_deduct').click(function(event) {
        event.preventDefault();
        var _this = $(this);
        //var numInp = _this.closest('.num_box').find('.shopping_num');
        var numInp = _this.closest('.it_num').find('.dp_num');
        var num = Math.abs(parseInt(numInp.val()));
        num--;
        count = -1;
        if(num < 1) {
            cartTips(event,'err','商品数量必须大于1同时小于99');
            return true;
        }
        //var rowid = _this.closest('tr').find('.productcheck').val();
        var rowid = _this.closest('.gooditem').find('.it_mck .mck').attr('cart-sku');
        var warehouse_id = numInp.attr('warehouse_id');
        var size = _this.closest('.gooditem').find('.it_size').text();
        if(!size) {
            size = 'SINGLE';
        }
        var pro = {
            id:rowid,
            count:count,
            num:num,
            size:size,
            //opid:_this.closest('tbody').data('pid')
            warehouse_id:parseInt(warehouse_id),
            opid:_this.closest('.cl_con').data('pid')
        }
        //if (!_this.closest('tbody').data('pid')) {
        if (!_this.closest('.cl_con').data('pid')) {
            pro.opid = 0
        }
        
        changeNum(numInp,pro,event)
    });    

    $('#combination').delegate('.addToCart','click',function(e){
        e.preventDefault();
        var item_id = $(this).data('id');
        addToCart(item_id,e);
    });
    $('.removeAll').confirm({
        msg:'确定要删除已选中商品吗？',
        modal:true,
        before:function(e){
            var _this = $(e.target);
            if (_this.parents('.cashier_part').prev().find('input[name="productcheck"]').length == 0) {
                cartTips(e,'err','请选择要删除的商品！');
                return false;
            }
        },
        onOK:function(e){
            var _this = $(e.target);
            var _row_id =[];
            _this.parents('.cashier_part').prev().find('input[name="productcheck"]').each(function(){
                if($(this).prop('checked')) {
                    _row_id.push($(this).val());    
                }
            });
            var sugs = {
                target:e,
                rowid:_row_id
            }
            partDelete(sugs);
        }
    });
    $('#removeFail').confirm({
        msg:'确定要删除失效的商品吗？',
        tit:'删除失效商品',
        before:function(e){
            if ($('.gooditem[failrowid]').length == 0) {
                cartTips(e,'err','没有已失效的商品！');
                return false;
            }
        },
        onOK:function(e){
            var _this = $(e.target);
            var _row_id =[];
            $('#shopping_cart .gooditem[failrowid]').each(function(){
                _row_id.push($(this).attr('failrowid'));    
            });
            var sugs = {
                target:e,
                rowid:_row_id
            }
            partDelete(sugs);
        }
    });
    $('.batchAddMine').confirm({
        msg:'确定将选中的商品移入收藏夹吗？',
        tit:'移入收藏夹',
        before:function(e){
            var _this = $(e.target);
            if ($(_this).parents('.cashier_part').prev().find('input[name="productcheck"]:checked').length == 0) {
                cartTips(e,'err','请选择要移入收藏夹的商品！');
                return false;
            }
        },
        onOK:function(e){
            var _this = $(e.target);
            var _sku =[];
            var _row_id =[];
            _this.parents('.cashier_part').prev().find('input[name="productcheck"]').each(function(){
                if($(this).prop('checked')) {
                    _sku.push($(this).attr('cart-sku'));    
                    _row_id.push($(this).val());  
                }
            });
            var sugs = {
                target:e,
                rowid:_row_id
            }
            
            $.ajax({
                  url: '/instant/collect/ajaxBatchAddMine',
                  type: 'POST',
                  dataType: 'json',
                  data: {item_id:_sku},
                  success: function(data) {
                    if(data.res) {
                        partDelete(sugs);
                    }
                    cartTips(e,'err',data.data)

                  }
                })
            
        }
    });
})
function formSubmit(e){
    var _row_id   =[];
    //选中的商品列表
    $('input[name="productcheck"]').each(function(){
        if($(this).prop('checked')) {
            _row_id.push($(this).val());    
        }
    });
    if(_row_id.length < 1) {
        cartTips(e,'err','请选择要结算的商品');
        return false;
    }
    var tipDelay = 2000;

    $.ajax({
        url:'/instant/cart/saveCartContents',
        cache:false,
        type:'POST',
        dataType: 'json',
        data: {
            warehouse_id:warehouse_id
        },
        beforeSend:function(){
            $('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').hide();
            if($('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').parent().find('.submitloading').length) {
                $('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').parent().find('.submitloading').show();
            } else {
                $('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').parent().append('<span id="submitloading" class="submitloading">结算中...</span>');    
            }
            
        },
        success:function(data){
            popNotShow = 0;
            $('.btnJieSuan[data-warehouse="'+warehouse_id+'"]').show();
            $('.submitloading').remove();
            switch(data.code){
                case 2:
                // ajaxLogin('/order');
                window.location.href = '/login?url=/cart';
                break;
                case 0:
                cartTips(e,'err',data.msg);
                setTimeout(function(){
                    window.location.reload();
                },tipDelay);
                break;
                case 3:
                //cartTips(e,'err',data.msg);
                $('.popCart_name,.popBg').show();
                /*setTimeout(function(){
                    window.location.href = '/my_identification.html';
                },tipDelay);*/
                break;
                case 4:
                cartTips(e,'err',data.msg);
                setTimeout(function(){
                    window.location.href = '/dutyfree.html';
                },tipDelay);
                break;                
                case -3:
                changeTotal(e);
                cartTips(e,'err',data.msg);
                setTimeout(function(){
                    window.location.reload();
                },tipDelay);
                break;
                case 1:
                window.location.href = '/order?w='+data.warehouse_id;
                break;
                default:
                cartTips(e,'err',data.msg);
            }
        }
    });
}
function changePromotion(info,event){
    //console.log(info);
    //var promotionItem = $('tbody[data-pid='+ info.opid +']').find('tr').length ;
    var promotionItem = $('div.cl_con[data-pid='+ info.opid +']').find('.cl_tag').length ;
    if (promotionItem == 0) {
        //$('thead[data-pid='+ info.opid +']').remove();
        //$('tbody[data-pid='+ info.opid +']').remove();
        //$('div.cl_con[data-pid='+ info.opid +']').find('.cl_tag').remove();
        //$('div.cl_con[data-pid='+ info.opid +']').find('.cl_words').remove();

        getNoPromotionItemNum();
        changeTotal(event);
    }else{
        $.ajax({
            url: '/instant/cart/checkPromotions',
            type: 'POST',
            dataType: 'json',
            data: info,
            success: function(data) {
            //called when successful
                if (data.code == 1) {
                    if (data.active != 1 ) {
                        var div = $('div.cl_con[data-pid='+ data.pid +']');
                        div.find('.cl_tag').addClass('disabled_h');
                        //div.find('.cl_words span').remove();
                        div.find('.cl_words em').html('(还差'+ data.diff +'元满足活动条件)');
                        
                        div.find('div[data-gift='+data.pid+']').remove();
                        $('#shopping_cart div[data-fpid='+ data.pid +']').remove();
                    }else{
                        var div = $('div.cl_con[data-pid='+ data.pid +']');
                        div.find('.cl_tag').removeClass('disabled_h');
                        div.find('.cl_words span').remove();
                        if(data.gift == 1) {
                            if (div.find('div[data-gift='+data.pid+']').length == 0) {
                                html = '<div data-gift="'+data.pid+'"><a href="javascript:;" class="btn_xzzp selectBonus">选择赠品<i></i></a></div>';
                                div.find('.cl_tit').append(html);
                            }
                        }
                        if(data.gift == 2) {
                            if (div.find('.cl_mck .mck').prop('checked')) {
                                div.find('.cl_tag').removeClass('disabled_h');
                                if (div.find('div[data-gift='+data.pid+']').length == 0) {
                                    html = '<div data-gift="'+data.pid+'"><a href="javascript:;" class="btn_xzzp selectBonus">选择赠品<i></i></a></div>';
                                    div.find('.cl_tit').append(html);
                                }
                            } else {
                                div.find('.cl_tag').addClass('disabled_h');
                                div.find('div[data-gift='+data.pid+']').remove();
                            }
                        }
                        //makePromotion(data);
                    }

                    changeTotal(event);
                }else{
                    cartTips(event,'err',data.msg)
                }
            }
        })
    }
    
}
function addPromotionInfo(data){
    //删除之前参加的活动优惠信息
    // if (data.gift != 2) {
    //     $('#myShopPromotionArea p[data-pid='+ data.opid +']').remove();
    //     $('#myShopPromotionArea p[data-fpid='+ data.opid +']').remove();
    // }else{
    //     $('#myShopPromotionArea p[data-rowid='+ data.row_id +']').remove();
    //     $('#myShopPromotionArea p[data-frowid='+ data.row_id +']').remove();
    // }
    makePromotion(data);
}
function makePromotion(data){
    //console.log(data)
    var infoConn = $('#myShopPromotionArea .rim .l');
    th = $('thead[data-pid='+ data.pid +']');
    if (data.pid != 0) {
        if (data.active == 1) { //如果符合条件则显示新活动
            th.find('.diff').remove();
            if (infoConn.find('p').length == 0) {
                infoConn.html('<h6>已参与优惠活动</h6>');
            }
            var html;
            switch(data.gift){
                case 0:
                if (infoConn.find('p').filter('[data-pid="'+ data.pid +'"]').length == 0) {
                    html = '<p data-pid="'+ data.pid +'">'+ data.pname + '</p>';
                }
                break;
                case 1:
                if (infoConn.find('p').filter('[data-pid="'+ data.pid +'"]').length == 0) {
                    html = '<p data-pid="'+ data.pid +'">'+ data.pname + '<a href="#" class="selectBonus">选赠品</a></p>';
                }
                break;
                case 2:
                if (infoConn.find('p').filter('[data-rowid="'+ data.row_id +'"]').length == 0 && data.row_id != undefined) {
                    html = '<p data-pid="'+ data.pid +'" data-rowid="'+ data.row_id +'">'+ data.pname + '<a href="#" class="selectBonus">选赠品</a></p>';
                }
                break;
            }
            infoConn.append(html);
        }else{
            th.find('.promico').addClass('noEnough');
            if(typeof(data.diff) !== 'undefined' && data.diff != 0){
                th.find('.txt .diff').remove();
                th.find('.txt').append('<span class="diff">(还差'+ data.diff +'元满足活动条件)</span>');
            }
            $('#myShopPromotionArea p[data-pid='+ data.pid +']').remove();
        }
    }
}
function stockOver(html){
    $("#dialog").html(html);
    $("#dialog").dialog({
        autoOpen:true,
        closeOnEscape:true,
        modal:true,
        width:740 ,
        position:'center'
    }).dialog("open");
}
//购物车提交
function ajaxLogin(url){
    $.ajax({
            url: "/login/fast_login?jumpurl="+url,
            success: function(html){
                $('select.actionlist').hide();
                        $("#dialog").html(html);
                        $("#dialog").dialog({
                            autoOpen:true,
                            closeOnEscape:true,
                            modal:true, 
                            width:720 ,
                            position:'center'
                        }).dialog("open");
                    }
        });
}
function addToCart(item_id,e) {
    var flag = true;
    if (item_id == '' || typeof(item_id) == 'undefined') {
        flag = false;
        cartTips(e,'err','请刷新重试');
    }

    //all infos are correct submit to ajax
    if (flag) {
        var _data = {
            count: 1,
            size : 'SINGLE',
            id : item_id
        }

        _tag.dcsMultiTrack('wt.pid', item_id, 'wt.nu', 1, 'wt.dl', '53');//alert(itemid)
        
        $.ajax({
            url:'/instant/cart/addToCartDirect',
            cache:false,
            dataType: 'json',
            data: _data,
            type: "POST",
            beforeSend:function(){
                $(e.target).css({visibility: 'hidden'}).before('<img src="/resources/images/ajax-loader.gif" class="loadimg" style="float:left;left:50px;position:relative;top:5px;">');
            },
            success:function(data){
                //添加购物车浮层
                setTimeout(function(){
                    $(e.target).css({visibility: 'visible'});
                    $('.loadimg').remove()
                },800)
                cartRelated(e,data);
                window.location.reload();
            }
        });
    }
}

function cartRelated(e,data){
    var targetelement = $(e.target);
    var _target={
        left   : targetelement.offset().left,
        top    : targetelement.position().top,
        parent : targetelement.parent(),
        _html  : data.msg
    };
    if (data.code > 0 ) {
        $('<div />')
            .addClass('addCartOk')
            .css({top:_target.top,left:_target.left - _target.parent.offset().left})
            .html('已加入购物车')
            .appendTo(_target.parent)
            .delay(1200)
            .animate({opacity:0,left:'+=250',top:'-=450'},300,function(){
            $(this).remove();
            ajaxReq();
        });
    }else{
        $('<div />')
            .addClass('addCartErr')
            .css({top:_target.top-10,left:_target.left})
            .html('请刷新重试')
            .appendTo(_target.parent)
            .delay(1000)
            .animate({opacity:0},500,function(){
                $(this).remove();
            });
    };

}

function changeSelect(num,event) {
    $.ajax({
        url: '/instant/cart/changeSelect',
        type: 'POST',
        dataType: 'json',
        data: num,
        success: function(data) {
            if (data.code == 0) {
                changePromotion(num,event);
            }else{
                cartTips(event,'err',data.msg);
            };
        }
    });
}

function batchChangeSelect(num,event) {
    $.ajax({
        url: '/instant/cart/changeSelect',
        type: 'POST',
        dataType: 'json',
        data: num,
        success: function(data) {
            if (data.code == 0) {
                batchChangePromotion(num,event);
            }else{
                cartTips(event,'err',data.msg);
            };
        }
    });
}

function getNoPromotionItemNum() {
    var noPromotionItemNum = 0;
    $('#shopping_cart .cl_con[data-pid=0] .it_mck .mck').each(function(){
        noPromotionItemNum += parseInt($(this).parents('.it_mck').siblings('.it_num').find('.dp_num').val());
    })
    $('#shopping_cart .cl_con[data-pid=0] .cl_words span').text(noPromotionItemNum);
}

function batchChangePromotion(info,event){
    if(typeof(info.opid) == 'undefined' || info.opid == '') {
        getNoPromotionItemNum();
        changeTotal(event);    
    } else {
        $.ajax({
            url: '/instant/cart/batchCheckPromotions',
            type: 'POST',
            dataType: 'json',
            data: info,
            success: function(da) {
                if (da.code == 1) {
                    for(i = 0; i < da.data.length; i++) {
                        data = da.data[i];
                        if (data.active != 1 ) {
                            var div = $('div.cl_con[data-pid='+ data.pid +']');
                            div.find('.cl_tag').addClass('disabled');
                            div.find('.cl_words span').remove();
                            //div.find('.cl_words').append('<span>(还差'+ data.diff +'元满足活动条件)</span>');
                            div.find('div[data-gift='+data.pid+']').remove();
                        }else{
                            var div = $('div.cl_con[data-pid='+ data.pid +']');
                            div.find('.cl_tag').removeClass('disabled');
                            div.find('.cl_words span').remove();
                            if(data.gift == 1) {
                                if (div.find('div[data-gift='+data.pid+']').length == 0) {
                                    html = '<div data-gift="'+data.pid+'"><a href="javascript:;" class="btn_xzzp selectBonus">选择赠品<i></i></a></div>';
                                    div.find('.cl_tit').append(html);
                                }
                            }
                            if(data.gift == 2) {
                                if (div.find('.cl_mck .mck').prop('checked')) {
                                    div.find('.cl_tag').removeClass('disabled');
                                    if (div.find('div[data-gift='+data.pid+']').length == 0) {
                                        html = '<div data-gift="'+data.pid+'"><a href="javascript:;" class="btn_xzzp selectBonus">选择赠品<i></i></a></div>';
                                        div.find('.cl_tit').append(html);
                                    }
                                } else {
                                    div.find('.cl_tag').addClass('disabled');
                                    div.find('div[data-gift='+data.pid+']').remove();
                                }
                            }
                        }    
                    }
                    getNoPromotionItemNum();
                    changeTotal(event);
                }else{
                    cartTips(event,'err',da.msg)
                }
            }
        })
    }
    getNoPromotionItemNum();
}

function changeNum(obj,num,event){
    var _o=null, objClass=obj.attr('class');
    if(objClass=='dp_jian')_o=obj;
    else if(objClass=='dp_jia')_o=obj.prev().prev();
    else _o=obj.prev();
    $.ajax({
        url: '/instant/cart/addToCart',
        type: 'POST',
        dataType: 'json',
        data: num,
        success: function(data) {
            var inp = obj;
            if (data.code == 1) {
                obj.val(num.num);
                var spuid=obj.attr('rowid');
                $('.rowid-'+spuid).each(function(){
                    var ts = $(this);
                    //var ele = ts.find('.spuitem_num');
                    var ele = ts.find('.spuitem_num');
                    ele.text(ele.data('qty')*num.num);
                });
                
                if (parseInt(num.num) <= 1) {
                    //$(".num_reduce").addClass('num_reduce_disabled');
                    _o.addClass('disabled');
                } else {
                    //$(".num_reduce").removeClass('num_reduce_disabled');
                    _o.removeClass('disabled');
                }
                cartTips(event,'success','数量修改成功');
                if (inp.data('ori')) {
                    inp.data('ori',num.num);
                };
                //obj.closest('tr').find('.subTotal').text( "￥" + data.subtotal);
                obj.closest('.gooditem').find('.subTotal').text( "￥" + data.subtotal);
                //num.event = event;
                //console.log(num)
                changePromotion(num,event);
                
            }else{
                cartTips(event,'err',data.msg);
                if (inp.data('ori')) {
                    inp.val(inp.data('ori'));
                };
            };

        }
    });
}



function partDelete(sugs){
    $.ajax({
        url:'/instant/cart/removeItems',
        type:'POST',
        dataType: 'json',
        data: {
            row_id:sugs.rowid
        },
        success:function(data){
            /*window.location.reload();
            return;*/
            switch(data.code){
                case 0:

                    //更新页面商品列表
                    var gift =[];
                    for (var i = 0; i < sugs.rowid.length; i++) {
                        var productr = $('#shopping_cart input[value='+sugs.rowid[i]+']').closest('.gooditem');
                        var tbody = productr.parents('.cl_con');
                        var promotion = productr.parents('.cl_promotion');
                        var pid = tbody.data('pid');
                        _btmtop-=productr.outerHeight(true);
                        productr.remove();
                        if (promotion.find('.gooditem').length == 0 ) {
                            _btmtop-=tbody.outerHeight(true);
                            //$('.cl_con[data-pid='+ pid +']').remove();
                            promotion.remove();
                        }
                        
                        //$('#data-remove'+sugs.rowid[i]).remove();
                        if (tbody.find('.gooditem').length == 0 ) {
                            _btmtop-=tbody.outerHeight(true);
                            //$('.cl_con[data-pid='+ pid +']').remove();
                            tbody.parent().next().remove();
                            tbody.parent().remove();
                            $('#shopping_cart .c_list').eq(0).css('margin-top','0px');
                        }
                    };
                    changeBtmFixed();
                    if ($('#shopping_cart .gooditem').length<1) {
                        window.location.reload();
                    };
                    var t = $(sugs.target).closest('td');
                    var info={
                        opid:pid || 0,
                        row_id:sugs.rowid
                    }
                    changePromotion(info,sugs.target);
                break;
                default:
                    cartTips(sugs.target,'err',data.msg);
            }
        }
    });
}
function changeTotal(e){
    var i = 0;
    var rowid_data = {row_id:[]};
    $("#shopping_cart input[name=productcheck]").each(function(){
        if($(this).prop('checked')) {
            rowid_data.row_id[i] = $(this).val();
            i++;    
        }
        
    })
    var beforesendflag = true;
    var get_total_url = "/instant/cart/getTotal";
    $.ajax({
        url:get_total_url,
        type:"POST",
        data:rowid_data,
        dataType:"json",
        beforeSend:function(){
            if (beforesendflag == true){
                beforesendflag = false;
                return true;
            } else {
                return false;
            }
        },
        success:function(data){
            if (data.code == 1) {
                $.each(data.cartData,function(k,v){
                    $('#product_total_price_'+v.warehouse_unique_id).text('¥'+v.product_total_price);
                    $('#thrift_price_'+v.warehouse_unique_id).text('-¥'+v.thrift_price);
                    if(typeof(v.taxes_price) == 'undefined') {
                        v.taxes_price = 0;
                    }
                    $('#taxes_price_'+v.warehouse_unique_id).text('¥'+v.taxes_price);
                    //$('#limit_tax_'+v.warehouse_unique_id).text(v.limit_tax);
                    if(parseFloat(v.taxes_price) < parseFloat(v.limit_tax)) {
                        $('#taxes_price_'+v.warehouse_unique_id).siblings('.cart_sf_bg').hide();
                        $('#taxes_price_'+v.warehouse_unique_id).css('text-decoration','line-through').text('¥'+v.taxes_price);
                    } else {
                        
                        $('#taxes_price_'+v.warehouse_unique_id).siblings('.cart_sf_bg').text('关税≤50，才能免征哦').show();
                        $('#taxes_price_'+v.warehouse_unique_id).css('text-decoration','none').text('¥'+v.taxes_price);
                    }
                    $('#total_quantity_'+v.warehouse_unique_id).text(v.total_quantity);
                    $('#total_pay_'+v.warehouse_unique_id).text(v.total_pay);
                    for(i = 0; i < v.item_group.length; i++) {
                        if(typeof(v.item_group[i]['promotion']) != "undefined") {
                            w_p = $('div[data-warehouse="'+v.warehouse_unique_id+'"]').find('div[data-promotion="'+v.item_group[i].promotion.id+'"]');
                            if(typeof(v.item_group[i].full_diff_money) != "undefined") {
                                w_p.find('.cl_tag').addClass('disabled_h');
                                w_p.find('.cl_words_zp').remove(); 
                                w_p.find('a.selectBonus').hide(); 
                                w_p.find('.zpwh').remove(); 
                                if(w_p.find('.cl_words span.full_diff_money').length) {
                                    if(v.item_group[i].full_diff_money != '') {
                                        w_p.find('.cl_words span.full_diff_money').text('(还差'+v.item_group[i].full_diff_money+'元满足活动条件)').show();
                                        w_p.find('.cl_words > a.cd').show();   
                                    } else {
                                        w_p.find('.cl_words span.full_diff_money').hide(); 
                                    }
                                } else {
                                    if(v.item_group[i].full_diff_money != '') {
                                        cd = '<span class="full_diff_money">(还差'+v.item_group[i].full_diff_money+'元满足活动条件)</span>';
                                        cd += '<a href="/';
                                        if(v.item_group[i].promotion.outlet_id > 1) {
                                            cd += 'list-'+v.item_group[i].promotion.outlet_id;
                                        } else {
                                            cd += 'promotion-'+v.item_group[i].promotion.id;
                                        }
                                        
                                        cd += '.html" class="cd" target="_blank">去凑单 ></a>';
                                        w_p.find('.cl_words').append(cd);
                                    } else {
                                        w_p.find('.cl_words span.full_diff_money').hide();
                                    }
                                }
                            } else {
                                w_p.find('.cl_tag').removeClass('disabled_h');
                                w_p.find('.cl_words span.full_diff_money').hide();
                                w_p.find('.cl_words > a').hide();
                                promotion_type = w_p.find('.cl_tag').attr('data-promotion_type');
                                if(promotion_type == 'normal_gift' || promotion_type == 'full_gift') {
                                    if(w_p.find('.cl_words_zp').length) {
                                        w_p.find('.cl_words_zp').show();
                                        w_p.find('.cl_words_zp .selectBonus').show();
                                    } else {
                                        if(w_p.find('.cl_words .selectBonus').length) {
                                            w_p.find('.cl_words .selectBonus').show();
                                        } else {
                                            if(v.item_group[i]['promotion']['seleted_gift']) {
                                                zp = '<span class="cl_words_zp">';
                                                zp += '<em>[赠品]</em>';
                                                for(j = 0; j < v.item_group[i]['promotion']['gift_lists'].length; j++) {
                                                    if(v.item_group[i]['promotion']['gift_lists'][j]['status'] == 1 && v.item_group[i]['promotion']['gift_lists'][j]['id'] == v.item_group[i]['promotion']['seleted_gift']) {
                                                        zp += v.item_group[i]['promotion']['gift_lists'][j]['name'];        
                                                    }
                                                }
                                                zp += '<a class="cart_zp_btn btn_xzzp selectBonus" href="javascript:void(0)">重新选择</a>';
                                                zp += '</span>';
                                                
                                                w_p.find('.cl_words').append(zp);
                                            } else {
                                                if(v.item_group[i]['promotion']['giftStatusOkCount']) {
                                                    w_p.find('.cl_words').append('<a class="cart_zp_btn btn_xzzp selectBonus" href="javascript:void(0)">选择赠品</a>');    
                                                } else {
                                                    if(w_p.find('.cl_words').find('.zpwh').length) {
                                                        w_p.find('.cl_words').find('.zpwh').show();
                                                    } else {
                                                        w_p.find('.cl_words').append('<span class="zpwh">[已赠完]</a>');     
                                                    }
                                                    
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                    }
                })
                return true;
            } else {
                return false;
            }
        }
    });
}


function cartTips(e,flag,msg){
    var $tipsDelay  = 4000;
    $('.checkTipsErr').remove();
    $('.checkTips').remove();
    var _this;
    if (flag =="err") {
        _class = 'checkTipsErr'
    }else{
        _class = 'checkTips';
    };
    //console.log(e)
    if (e) {
        $('<p />')
            .addClass(_class)
            .css({opacity:0})
            .html(msg)
            .appendTo($('body'))
            .append('<i class="arr" />');
        
            if (flag =="err") {
                _this = $('.checkTipsErr');
            }else{
                _this = $('.checkTips');
            };
        _this.css({top:$(e.target).offset().top,left:_getLeft(),'z-index':9999,'margin-left':0})
        .animate({opacity:1,top:"-=30"},100)
        .delay($tipsDelay)
        .animate({opacity:0},500,function(){
            $(this).remove();
        });
    }
    function _getLeft(){
        return  $(e.target).offset().left - _this.width()/2;
    }
}

//底部固定效果
/*20151022 改版 取消此效果 lz*/
function changeBtmFixed(){
    /*
    var _sc=$(window).scrollTop();
    if((_sc+winH)<(_btmheight+_btmtop)){
        if(!$btm.hasClass('fixed_c_count'))$btm.addClass('fixed_c_count');
    }else{
        $btm.removeClass('fixed_c_count');
    }
    */
}
            
            
         