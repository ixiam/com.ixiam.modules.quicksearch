CRM.$(function($) {
  $('#civicrm-menu').ready(function() {
    // get the quickserach bar elements and hide them as settings
    $('ul li label.crm-quickSearchField input[name="quickSearchField"]').each(function() {
      var fieldname = $(this).val();
      if(fieldname != ""){
        if(jQuery.inArray(fieldname, CRM.vars.quicksearch.listEnabled) === -1){
          $(this).closest("li").hide();
        }
      }
    });
  });
});
