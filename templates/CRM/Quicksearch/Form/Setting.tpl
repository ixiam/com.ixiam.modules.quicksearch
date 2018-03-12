{crmScope extensionKey='com.ixiam.modules.quicksearch'}
<div class="crm-block crm-form-block crm-quicksearch-form-block">
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>
  <table class="form-layout">
    <tr class="crm-quicksearch-form-block-quicksearch_basic_fields">
      <td class="label">
        {$form.quicksearch_basic_fields.label}
      </td>
      <td>
        {$form.quicksearch_basic_fields.html}<br />
        <span class="description">{ts}These are the basic fields including by default in the Quicksearch{/ts}</span><br />
      </td>
    </tr>
    <tr class="crm-quicksearch-form-block-quicksearch_basic_fields">
      <td class="label">
        &nbsp;
      </td>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr class="crm-quicksearch-form-block-quicksearch_custom_fields">
      <td class="label">
        {$form.quicksearch_custom_fields.label}
      </td>
      <td>
        {$form.quicksearch_custom_fields.html}
        <span class="description">{ts}Enable custom fields to be included in Quicksearch. Only custom fields that extend from Contact, Individual, Organization and Household, and are searchable are shown in this list.{/ts}</span><br />
      </td>
    </tr>
  </table>
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
{/crmScope}
