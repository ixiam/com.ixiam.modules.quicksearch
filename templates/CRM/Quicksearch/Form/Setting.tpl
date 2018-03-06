{crmScope extensionKey='com.ixiam.modules.quicksearch'}
<div class="crm-block crm-form-block crm-quicksearch-form-block">
  <div class="help">
  {ts}...{/ts}
  </div>
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>
  <table class="form-layout">
    <tr class="crm-quicksearch-form-block-quicksearch_basic_fields">
      <td class="label">
        {$form.quicksearch_basic_fields.label}
      </td>
      <td>
        {$form.quicksearch_basic_fields.html}
      </td>
    </tr>
  </table>
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
{/crmScope}
