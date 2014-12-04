<script type="text/x-handlebars-template" id="tpl-location-content">
  <h1>{{ title }}</h1>

  {{#if has_events}}
    {{#if case_studies}}
      <h2>Case Studies</h2>
      <ol>
        {{#each case_studies}}
          {{> item}}
        {{/each}}
      </ol>
    {{/if}}

    {{#if galleries}}
      <h2>Galleries</h2>
      <ol>
        {{#each galleries}}
          {{> item}}
        {{/each}}
      </ol>
    {{/if}}
  {{else}}
    <p>
      <em>No events found for this location.</em>
    </p>
  {{/if}}
</script>
