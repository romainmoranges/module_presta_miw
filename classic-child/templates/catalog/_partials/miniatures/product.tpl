{block name='product_miniature_item'}
  <article class="product-miniature js-product-miniature col-lg-2 col-md-4 col-sm-6" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container">
      {block name='product_thumbnail'}
        {if $product.cover}
          <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
              src = "{$product.cover.bySize.home_default.url}"
              alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
              data-full-size-image-url = "{$product.cover.large.url}"
            >
          </a>
        {else}
          <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
              src = "{$urls.no_picture_image.bySize.home_default.url}"
            >
          </a>
        {/if}
      {/block}

      <div class="product-description">
        {block name='product_name'}
          {if $page.page_name == 'index'}
            <h3 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h3>
          {else}
            <h2 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h2>
          {/if}
        {/block}

        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping">
              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
                <span class="regular-price">{$product.regular_price}</span>
                {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
              <span itemprop="price" class="price">{$product.price}</span>

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
          {/if}
        {/block}

        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}
      </div>

      {block name='product_flags'}
        <ul class="product-flags">
          {foreach from=$product.flags item=flag}
            <li class="product-flag {$flag.type}">{$flag.label}</li>
          {/foreach}
        </ul>
      {/block}

      <div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">
        {block name='quick_view'}
          <a class="quick-view" href="#" data-link-action="quickview">
            <i class="material-icons search">&#xE8B6;</i> {l s='Quick view' d='Shop.Theme.Actions'}
          </a>
        {/block}

        {block name='product_variants'}
          {if $product.main_variants}
            {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
          {/if}
        {/block}
      </div>

    </div>
  </article>
{/block}
