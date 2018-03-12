CRM.$(function($) {
  $('#civicrm-menu').ready(function() {
    // hide basic fields in quickserach
    $('ul li label.crm-quickSearchField input[name="quickSearchField"]').each(function() {
      var fieldname = $(this).val();
      if(fieldname != ""){
        if(jQuery.inArray(fieldname, CRM.vars.quicksearch.basicFieldsEnabled) === -1){
          $(this).closest("li").hide();
        }
      }
    });

    // add custom fields in quickserach
    newItems = false;
    CRM.vars.quicksearch.customFieldsEnabled.forEach(function(entry) {
      var html =  '<li><label class="crm-quickSearchField"><input type="radio" data-tablename="custom_table" value="custom_' + entry + '" name="quickSearchField">Custom ' + entry + '</label></li>';
      // this selector could be improved?
      $('ul li label.crm-quickSearchField').closest("ul").append(html);

      newItems = true;
    });

    // apply styles again if there's new menu entries
    /*
    if(newItems){
      $('#root-menu-div .outerbox').css({'margin-top': '6px'});
      $('#root-menu-div .menu-ul li').css({'padding-bottom': '2px', 'margin-top': '2px'});
      $('img.menu-item-arrow').css({top: '4px'});
      $("#civicrm-menu >li").each(function(i){
        $(this).attr("tabIndex",i+2);
      });
    }
    */

  });
});
