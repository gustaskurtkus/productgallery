<div class="product-gallery">
    <div class="alert alert-warning" style="display: none;">
        <p></p>
    </div>

    <div class="alert alert-success" style="display: none;">
        <p></p>
    </div>

    <div class="form">
        <h2>{l s='Form' mod='productgallery'}</h2>

        <input type="file" id="file-input">
        <input type="hidden" id="id_product" value="{$id_product}">
        <button id="submit-product-gallery" type="button" class="btn btn-primary pull-right">{l s='Add New' mod='productgallery'}</button>
    </div>

    <div class="list">
        <h2>Gallery</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            {foreach $images as $key=> $image}
                <tr>
                    <td><img src="{$images_path}{$image.filename}" alt="..." class="img-thumbnail" width="150" height="150" style="object-fit: cover; width: 150px; height: 150px;"></td>
                    <td>
                        <button class="btn btn-danger delete-image" data-product-gallery-id="{$image.id_productgallery}">Delete</button>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
</div>




