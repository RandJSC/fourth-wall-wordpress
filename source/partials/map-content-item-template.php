<script type="text/x-handlebars-template" id="tpl-item-partial">
  <li>
    <div class="thumbnail">
      {{#if this.featured_image}}
        <a href="{{ this.link }}">
          {{#with this.featured_image.attachment_meta.sizes.thumbnail}}
            <img src="{{ url }}" width="{{ width }}" height="{{ height }}">
          {{/with}}
        </a>
      {{/if}}
    </div>
    <div class="item-content">
      <h3>
        <a href="{{ this.link }}">{{ this.title }}</a>
      </h3>
      <div class="date">
        {{ formatDate this.event_date }}
      </div>

      {{{ this.excerpt }}}
    </div>
  </li>
</script>
