const main_url = document.querySelector("#base_url").getAttribute("url");

/**
 *
 * Set Token
 */
const addToCart = (btn) => {
    // Get Tr
    const tableRow = btn.parentElement.parentElement;

    // Get Products
    let prod = tableRow.querySelector(".prodId").getAttribute("set");
    // Get Products
    let qty = tableRow.querySelector(".prodQty").value;
    if (parseInt(qty) == NaN || qty == 0) {
        Swal.fire({
            title: "No Quantity?",
            text: "You must add atleast 1 item",
            icon: "question",
        });
        return;
    }

    // URL
    let url_to_cart = main_url + `/add-to-cart?p=${prod}&q=${qty}`;
    // Redirect

    window.location.href = url_to_cart;
};
