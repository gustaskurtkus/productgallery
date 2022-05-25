<ul class="product-images">
    {foreach $images as $image}
        <li class="thumb-container">
            <img
                class="thumb js-thumb"
                src="{$images_path}{$image.filename}"
                width="100"
                height="100"
                style="object-fit: cover;"
            >
        </li>
    {/foreach}
</ul>
