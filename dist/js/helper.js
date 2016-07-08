/////////////////////////
//// Created by Reyp
(function($) {
  $.extend({
    alertMsg: function(options){
      var opt = $.extend({
        msg     : '',
        type    : 'success'
      }, options);
      var n = noty({
         text        : opt.msg,
         type        : opt.type,
         dismissQueue: true,
         layout      : 'topCenter',
         theme       : 'defaultTheme',
         animation  : {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500 // opening & closing animation speed
          }
     }).setTimeout(3000);
    },
    fetch: function(options){
      var opt = $.extend({
        func       :   '',
        key        :   '',
        onComplete :   function(response){}
      }, options);
      if(opt.func != ''){
        $.post(baseUrl+'fetch/'+opt.func+'/'+opt.key,function(data){
            opt.onComplete.call(this,data.details);
        },"json").fail( function(xhr, textStatus, errorThrown) {
          alert(xhr.responseText);
        });
      } 
    },
    rPrint: function(printUrl){
      var width = screen.availWidth-80;
      var height = screen.availHeight-80;
      window.open (baseUrl+printUrl,"print",'toolbar=no,width='+width+',height='+height+',top=15,left=0,directores=no');
    },
  });
  $.fn.exists = function(){return this.length>0;}
  $.fn.serializeAnything = function() {

    var toReturn  = [];
    var els     = $(this).find(':input').get();

    $.each(els, function() {
      if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password/i.test(this.type))) {
        var val = $(this).val();
        toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
      }
    });

    return toReturn.join("&").replace(/%20/g, "+");
  }
  $.fn.rOkay = function(options)  {
    var settings = $.extend({
      passTo          :   this.attr('action'),
      addData         :   "",
      checkCart       :   null,
      validate        :   true,
      asJson          :   false,
      btn_load        :   null,
      goSubmit        :   true,
      bnt_load_remove :   true,
      onComplete  : function(response){}
    },options);
    function generate(text){
      var n = noty({
             text        : text,
             type        : 'error',
             dismissQueue: true,
             layout      : 'topCenter',
             theme       : 'defaultTheme',
             animation  : {
                open: {height: 'toggle'},
                close: {height: 'toggle'},
                easing: 'swing',
                speed: 500 // opening & closing animation speed
              }
         }).setTimeout(3000);
    }
    var errors = 0;
    var check_form = $(this);
    if(settings.validate){
      check_form.find('.rOkay').each(function(){
        if($(this).val() == ""){
          var txt = $(this).prev('label').text();
          var msg = $(this).attr('ro-msg');

          var display_msg = 'Alert! '+txt+' must not be empty.';
          if(typeof msg !== 'undefined' && msg !== false)
            display_msg = msg;
            
          generate(display_msg);
          $(this).focus();
          errors = errors+1;
          return false;
        }
        
      });
    }
    if(settings.goSubmit){
      if(errors == 0){
        var form = check_form;
        var formData = check_form.serialize();
        if(settings.addData != "")
          formData = formData+'&'+settings.addData;

        // alert(formData);
        if(settings.btn_load != null){
          // var pretext = check_form.attr('id');
          var pretext = check_form.attr('id');
          var lastTxt = settings.btn_load.html();
          // settings.btn_load.attr("disabled", "disabled").after(' <img src="'+baseUrl+'/images/preloader.gif" height="20" id="'+pretext+'-preloader">');
          settings.btn_load.attr("disabled", "disabled").html(lastTxt+' <i class="fa fa-spinner fa-spin fa-fw"></i>');
        }


        if(settings.asJson){
          if(settings.checkCart != null){
            $.post(baseUrl+'wagon/check_wagon/'+settings.checkCart,function(check){
              if(check.error > 0){
                settings.btn_load.html(lastTxt);
                settings.btn_load.removeAttr("disabled");
                generate('Error! '+ check.msg);
              }
              else{
                
                if(settings.btn_load != null && settings.bnt_load_remove){
                  settings.btn_load.html(lastTxt);
                  settings.btn_load.removeAttr("disabled");
                }

                $.post(baseUrl+settings.passTo,formData,function(data){
                  // alert(data);
                  settings.onComplete.call(this,data);
                // });    
                },"json").fail( function(xhr, textStatus, errorThrown) {
           alert(xhr.responseText);
        });    
              }
            },"json").fail( function(xhr, textStatus, errorThrown) {
           alert(xhr.responseText);
        });
          }
          else{
            $.post(baseUrl+settings.passTo,formData,function(data){
              if(settings.btn_load != null && settings.bnt_load_remove){
                settings.btn_load.html(lastTxt);
                settings.btn_load.removeAttr("disabled");
              }
              settings.onComplete.call(this,data);
            // });
            },"json").fail( function(xhr, textStatus, errorThrown) {
           alert(xhr.responseText);
        });
          }
        }
        else{
          if(settings.checkCart != null){
            $.post(baseUrl+'wagon/check_wagon/'+settings.checkCart,function(check){
              if(check.error > 0){
                settings.btn_load.html(lastTxt);
                settings.btn_load.removeAttr("disabled");
                generate('Error! '+ check.msg);
              }
              else{
                // alert(formData); 
                if(settings.btn_load != null && settings.bnt_load_remove){
                  settings.btn_load.html(lastTxt);
                  settings.btn_load.removeAttr("disabled");
                }
                $.post(baseUrl+settings.passTo,formData,function(data){
                  settings.onComplete.call(this,data);
                });   
              }
            },"json").fail( function(xhr, textStatus, errorThrown) {
           alert(xhr.responseText);
        });
          }
          else{
            $.post(baseUrl+settings.passTo,formData,function(data){
              if(settings.btn_load != null && settings.bnt_load_remove){
                settings.btn_load.html(lastTxt);
                settings.btn_load.removeAttr("disabled");
              }
              settings.onComplete.call(this,data);
            }); 
          }
        }
      }   
    }
    else{
      if(errors > 0)
        return false
      else
        return true;
    }
  }
  $.fn.rList = function(options)  {
    var atr = $.extend({
      div             :   this.find('.list-load'),
      table           :   this.find('.list-load').attr('table'),
      form            :   this.find('.list-load').attr('form'),
      view            :   this.find('.list-load').attr('view'),
      dflt            :   this.find('.list-load').attr('dflt-view'),
      onComplete      :   function(response){},
      gridClick       :   null,
    },options);
    var getUrl = 'lists/'+atr.table;
    var div = atr.div;
    $('.content').addClass('no-padding');
    $(this).find('.btn-create').click(function(){
      window.location = baseUrl+atr.form;
      return false;
    });
    if(getUrl == ""){
      noResults(div);
    }
    else{
      var view = atr.view;
      var dflt = atr.dflt;
      var pagi = 0;
      getData(div,view,dflt,pagi);
      $(this).find('.btn-view-list').click(function(){
          getData(div,view,'list',pagi);
      });
      $(this).find('.btn-view-grid').click(function(){
          getData(div,view,'grid',pagi);
      });
      $(this).find('.btn-view-filter').click(function(){
          bootbox.dialog({
            message: baseUrl+getUrl+'_filter',
            title: '<i class="fa fa-filter"></i> Filter',
            className: 'bootbox-filter',
            buttons: {
              submit: {
                label: "SUBMIT",
                className: "btn btn-success btn-flat",
                callback: function() {
                  var form = $('.bootbox-filter').find('form');
                  var search = form.serialize();
                  getData(div,view,dflt,pagi,search);
                  return true;
                }
              },
              cancel: {
                label: "CANCEL",
                className: "btn btn-default btn-flat",
                callback: function() {
                  // Example.show("uh oh, look out!");
                }
              }
            }
          });
          return false;
      });
    }
    function getData(div,view,dflt,pagi,search){
        div.removeClass('table-responsive');
        div.html('<center style="margin-top:50px;"><i class="fa fa-refresh fa-3x fa-spin"></i></center>');
        $('.listing').find('table').remove();
        $('.listing').find('.floatThead-container').remove();
        console.log(pagi);
        var formData = 'pagi='+pagi;
        if(typeof search !== 'undefined' && search !== false){
          formData += '&'+search;
        }  
        $.post(baseUrl+getUrl,formData,function(data){
          div.html('');
          var cols = data.cols;
          var rows = data.rows;
          if(rows.length == 0){
            noResults(div);
          }
          else{
            if(dflt == 'list'){
              listView(div,rows,cols);
            }
            else{
              gridView(div,rows,cols);
            }
            atr.onComplete.call(this,data);
            if(data.pagi != ""){
              $('.list-page-pagi').html(data.pagi);
              $('.pagination li a.ragi').click(function(data){
                var li = $(this).parent();
                if(!li.hasClass('disabled')){
                  var pagi = $(this).attr('pagi');
                  getData(div,view,dflt,pagi,search);
                }
                return false;
              });
            }  
          }
        },'json').fail(function(XMLHttpRequest, textStatus, errorThrown) {
          alert(XMLHttpRequest.responseText);
          // alert(textStatus);
          // alert(errorThrown);
        });
    }
    function gridView(div,rows,cols){
      // div.css({'background-color':'#f1f1f1','padding':'0px'});
      
      var row = $('<div class="list-card row no-padding no-margin"></div>');
      $.each(rows,function(key,val){
          var img = baseUrl+'dist/img/no-photo.jpg';
          if(val.hasOwnProperty('grid-image')){
            img = baseUrl+val['grid-image'];
          }  
          var reg_date = "";
          if(typeof val.reg_date !== 'undefined' && val.reg_date !== false){
            reg_date = ' <span class="info-box-text" style="font-size:12px; color:#888">'+val.reg_date+'</span> ';
          }
          var other = "";
          if(typeof val.other !== 'undefined' && val.other !== false){
            other = ' <span class="info-box-text" style="font-size:12px; color:#888">'+val.other+'</span> ';
          }
          var box_id = "";
          if(typeof val.tagid !== 'undefined' && val.tagid !== false){
            box_id = 'id="grid-box-'+val.tagid+'" ref="'+val.tagid+'"';
          }
          var col = $('<div class="col-md-3 no-margin grid-boxes" '+box_id+' style="padding:3px;"></div>');
          col.append('<div class="info-box" style="margin:0px;padding:0px;cursor:pointer">'
                        +'<span class="info-box-icon"><img src="'+img+'" style="max-width:90px; height:90px;vertical-align:initial !important;"></span>'
                        +'<div class="info-box-content">'
                          +'<span class="info-box-number" style="font-size:14px;">'+val.title+'</span>'
                          +'<span class="info-box-text" style="font-size:12px; color:#888">'+val.desc+'</span>'
                          +other
                          +reg_date
                          +'<span class="info-box-text" style="font-size:12px; color:#888">'+val.subtitle+'</span>'
                        +'</div>'
                      +'</div>'
                    +'</div>')
              .click(function(){
                 if($.isFunction(atr.gridClick)){
                    atr.gridClick.call(this,val);
                 }
                 else{
                   var link = val.link;
                   window.location = $(link).attr('href');
                 }
                 return false;
              });
          row.append(col);
      });
      div.append(row);
    }  
    function listView(div,rows,cols){
      // div.css({'background-color':'#fff','padding':'0px'});
      var tbl =  $('<table/>')
                  .addClass('table table-striped table-hover list-tbl');
      var thead = $('<thead/>');
      
      var thRow = $('<tr/>').appendTo(thead);
      $.each(cols,function(key,val){
          thRow.append('<td>'+val+'</td>');
      });
      var tbody = $('<tbody/>');
      $.each(rows,function(id,row){
        var tbRow = $('<tr/>');
        var hasInactive = false;
        $.each(row,function(ctr,dt){
          if(ctr == 'inactive' && dt == 1)
            hasInactive = true;
          if(ctr != 'grid-image' && ctr != 'inactive')
            tbRow.append('<td>'+dt+'</td>');
            
        });
        if(hasInactive)
          tbRow.addClass('inactive');
        tbody.append(tbRow);
      });
      tbl.append(thead);
      tbl.append(tbody);
      div.append(tbl);
     
      div.addClass('table-responsive');
      if($(window).width() > 650){
        tbl.floatThead({
            scrollContainer: function($table){
                return $table.closest('tbody');
            }
        });
      }
    }
    function noResults(div){
      div.html('<center style="margin-top:30px;font-size:16px;font-weight:bold;">No Results Found.</center>');
    }
  }
  $.fn.rLoad = function(options){
    var opts = $.extend({
      url         :   "",
    },options);
    $(this).html('<center style="padding:25px;"><span><i class="fa fa-refresh fa-3x fa-spin"></i></span></center>').load(baseUrl+opts.url);
  }
  $.fn.rTable = function(options){
    var opt = $.extend({
      table     :     $(this),
      cart      :     "cart",
      onAdd     :     function(response){},
      onRemove  :     function(response){},
    },options);
    var tbl = opt.table;
    var body = tbl.children('tbody');
    var form_row = body.find('tr.form-row');
    form_row.hide();
    addLink();
    // initialize();
    loadRow();

    var add = $('<a href="#" id="add" style="margin-right:3px;"><i class="fa fa-check fa-lg"></i></a>');
    var close = $('<a href="#" id="close"><i class="fa fa-times fa-lg"></i></a>');
    add.click(function(){
      var formData = form_row.serializeAnything();
      $.post(baseUrl+'cart/add/'+opt.cart,formData,function(data){
        console.log(data);
        createRow(data.id);
        opt.onAdd.call(this,data);
      },'json').fail( function(xhr, textStatus, errorThrown) {
         alert(xhr.responseText);
      });
      return false;
    });
    close.click(function(){
      form_row.hide();
      $('#add-item').show();
      return false;
    });
    form_row.find('td:last').append(add); 
    form_row.find('td:last').append(close); 
    function addLink(){
      var link = $('<a href="#" id="add-item">Add an Item</a>');
      var row = $('<tr></tr>');
      var td = $('<td colspan="100%" style="text-align:right;"></td>');
      link.click(function(){
        form_row.show();
        $(this).hide();
        return false;
      });
      link.appendTo(td);
      td.append('&nbsp;');
      td.appendTo(row);
      form_row.after(row);
      // body.find('tr:last-child').before('<tr><td colspan="100%">&nbsp;</td></tr>');
      body.find('tr:last-child').after('<tr><td colspan="100%">&nbsp;</td></tr>');
    }    
    function initialize(){
      $.post(baseUrl+'cart/initial/'+opt.cart);
    }
    function createRow(id){
      var txt = form_row.find('.rtbl-txt');
      var row = $('<tr class="rtbl-row" id = "rtbl-row-'+id+'"></tr>');
      txt.each(function(){
        var elem = $(this);
        var value = "";
        if(!elem.hasClass('bootstrap-select')){
          if(elem.is('input')){
            value = elem.val();
          }
          else if(elem.is('select')){
              value = elem.find("option:selected").text();
          }
          else{
            value = elem.text();
          }
          row.append('<td>'+value+'</td>');
        }
      });
      // var edit = $('<a href="#" id="edit-'+id+'" ref="'+id+'" style="margin-right:3px;"><i class="fa fa-edit fa-lg"></i></a>');
      var del = $('<a href="#" id="del-'+id+'" ref="'+id+'"><i class="fa fa-trash fa-lg"></i></a>');
      var td = $('<td colspan="100%" style="text-align:right;padding-right:10px;"></td>');
      del.click(function(){
        $.post(baseUrl+'cart/remove/'+opt.cart+'/'+id,function(){
          body.find('tr#rtbl-row-'+id).remove();
          opt.onRemove.call(this);
        });
        return false;
      });
      // edit.click(function(){
      //   var editRow = body.find('tr#rtbl-row-'+id);
      //   var index = editRow.index();
      //   var formIndex = form_row.index();
      //   editRow.hide();
      //   // form_row.index(index);
      //   body.find('tr').eq(index).after(form_row);
      //   return false;
      // });
      // td.append(edit);
      td.append(del);
      row.append(td);
      form_row.before(row);
    }
    function loadRow(){
      var dels = $('.del');
      dels.each(function(){
        $(this).click(function(){
          var id = $(this).attr('ref');
          if(id == "")
            id = 0;
          $.post(baseUrl+'cart/remove/'+opt.cart+'/'+id,function(){
            body.find('tr#rtbl-row-'+id).remove();
            opt.onRemove.call(this);
          });
          return false;
        });
      });
    }
  }
  $.fn.rView = function(loadUrl){
    var href = "";
    if(typeof loadUrl !== undefined && loadUrl !== false){
       href = $(this).attr('href');
    }
    else{
      href = loadUrl;
    }
    var boxTitle = "";
    var title = $(this).attr('title');
    if(typeof title !== undefined && title !== false){
      boxTitle = title;
    }
    $(this).click(function(){
      bootbox.dialog({
        message: baseUrl+href,
        title: boxTitle,
        className: 'bootbox-wide',
      });
      return false;
    });
  }
  $.fn.rVoid = function(options){
    var opts = $.extend({
      title       :       '<i class="fa fa-fw fa-warning"></i> Transaction Void',
      loadUrl     :       'void/form',
      onComplete  :       null,
    },options);
    $(this).click(function(){
      bootbox.dialog({
        message: baseUrl+opts.loadUrl,
        title: opts.title,
        className: 'bootbox-normal',
        buttons: {
          submit: {
            label: "<i class='fa fa-fw fa-times'></i> VOID",
            className: "btn btn-danger btn-flat void-submit-btn",
            callback: function() {
              var form = $('#void-form');
              form.rOkay({
                btn_load        :   $('.void-submit-btn'),
                bnt_load_remove :   false,
                onComplete      :   function(data){
                                        if($.isFunction(opts.onComplete)){
                                           opts.onComplete.call(this,val);
                                        }
                                        else{
                                          location.reload();
                                        }
                                    },
              });
              return false;
            }
          },
          cancel: {
            label: "CANCEL",
            className: "btn btn-default btn-flat",
            callback: function() {
              // Example.show("uh oh, look out!");
            }
          }
        }
      });
      return false;
    });
  }
}(jQuery));