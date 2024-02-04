
jQuery(document).ready(function(jQuery) {
    // Counter for unique IDs
    var comboCounter = 1;

    jQuery('.combo-button-custom').click(function() {
        var comboTemplateHTML = jQuery('#combo-template').html();

        // Create a new <div> element and set its HTML content
        var comboClone = jQuery('<div>').html(comboTemplateHTML);
        
        comboClone.attr('id', 'combo-' + comboCounter);
        comboClone.attr('class', 'combo-template');
        comboClone.css('display', 'block');
        
        // Append the cloned template to the desired location
        comboClone.appendTo('.custom-combo-repeater');
        comboCounter ++;
    });

    jQuery(document).on('click', '.remove-combo', function(event) {
        event.preventDefault();
        console.log('Remove button clicked');
        console.log(jQuery(this).closest('#combo-template'));
        jQuery(this).closest('.combo-template').remove();
    });
        
        
    jQuery(document).on("input", "#product-search-input", function() {
        var productDropdown = jQuery(this).siblings("#product-dropdown");
        var searchTerm = jQuery(this).val();
        let post_id = jQuery( "#post_ID" ).val();
        console.log(post_id);
        // Perform an AJAX request to get product search results
        jQuery.ajax({
            url: 'admin-ajax.php', // Use the WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'product_search', // This is the action hook on the server
                search_term: searchTerm,
                post_id : post_id
            },
            success: function(response) {
                productDropdown.html(response);
            }
        });
    });

    jQuery('.save-custom-combo').click(function() {
        var comboData = [];

        // Iterate through each combo
        jQuery('[class^="combo-"]').each(function() {
            var productId = jQuery(this).find('#product-dropdown').val();
            console.log(productId);
            var discount = jQuery(this).find('#combo_discount').val();
            console.log(discount);
            if (productId !== '') {
                comboData.push({
                    productId: productId,
                    discount: discount
                });
            }
        });
        console.log(comboData);
        let post_id = jQuery( "#post_ID" ).val();
        // Perform an AJAX request to save combo data
        jQuery.ajax({
            url: 'admin-ajax.php',
            type: 'POST',
            data: {
                action: 'save_combo_data',
                combo_data: comboData,
                post_id : post_id
            },
            success: function(response) {
                alert("Combo is added succesfully");
            }
        });
    }); 
});
