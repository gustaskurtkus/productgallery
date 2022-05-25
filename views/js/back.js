/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(window).ready(function() {
    $("button#submit-product-gallery").on("click", function(event) {
        event.preventDefault();

        var formData = new FormData();
        var files = $('.product-gallery #file-input')[0].files;

        formData.append('ajax', true);
        formData.append('action', 'upload');
        formData.append('file', files[0]);
        formData.append('id_product', $('#id_product').val());

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: ajaxUrl,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                let alert = $(".product-gallery .alert-success");
                let alertSuccessParagraph = $(".product-gallery .alert-success p");
                alertSuccessParagraph.html("");

                if (response.success) {
                    alertSuccessParagraph.append(response.message);
                    alert.show("slow");

                    let tableSelector = $("table tbody");
                    tableSelector.append(
                        "<tr>\n" +
                        "   <td><img src=" + response.data.url + " alt=\"...\" className=\"img-thumbnail\" width=\"150\"\n" +
                        "       height=\"150\" style=\"object-fit: cover; width: 150px; height: 150px;\"></td>\n" +
                        "   <td>\n" +
                        "   <button disabled class=\"btn btn-danger delete-image\"\n" +
                        "       data-product-gallery-id=" + response.data.id +">Delete\n" +
                        "   </button>" +
                        "</tr>"
                    );
                } else {
                    let alertWarning = $(".product-gallery .alert-warning");
                    let alertWarningParagraph = $(".product-gallery .alert-warning p");
                    alertWarningParagraph.html("");

                    alertWarningParagraph.append(response.message);
                    alertWarning.show("slow");
                }
            }
        });
    });

    $(".product-gallery .delete-image").on("click", function(event) {
        event.preventDefault();

        let element = $(this).closest("tr");
        let id = $(this).data("product-gallery-id");
        let formData = new FormData();
        formData.append('id_productgallery', id);
        formData.append('action', 'delete');

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: ajaxUrl,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let alert = $(".product-gallery .alert-success");
                let alertSuccessParagraph = $(".product-gallery .alert-success p");
                alertSuccessParagraph.html("");

                if (response.success) {
                    alertSuccessParagraph.append(response.message);
                    alert.show("slow");

                    element.remove();

                } else {
                    let alertWarning = $(".product-gallery .alert-warning");
                    let alertWarningParagraph = $(".product-gallery .alert-warning p");
                    alertWarningParagraph.html("");

                    alertWarningParagraph.append(response.message);
                    alertWarning.show("slow");
                }
            }
        });
    });
});



