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
    $.each(CRM.vars.quicksearch.customFieldsEnabled, function(id, label) {
      var html =  '<li style="position: relative; padding-bottom: 2px; margin-top: 2px;"><div class="menu-item"><label class="crm-quickSearchField"><input type="radio" data-tablename="custom_table" value="custom_' + id + '" name="quickSearchField">' + label + '</label></div></li>';
      // this selector could be improved?
      $('ul li label.crm-quickSearchField').closest("ul").append(html);

      newItems = true;
    });
  });
});
