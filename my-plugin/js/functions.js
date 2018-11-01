function closeModal() {
    document.getElementById("myModal").style.display = 'none';
}

function openModal() {
    document.getElementById("myModal").style.display = 'block';
}

jQuery(document).ready(function () {
    jQuery('.my-gallery-link').click(function (е) {
        е.preventDefault();
        let url =  jQuery(this).find('img').attr('src');

        let myModal = jQuery('#myModal');
        myModal.css('display', 'block');

        myModal.find('.modal-content').html('<img class="my-modal-image"  style="width:100%; height: auto; " src="' + url + '">');
    });
});
