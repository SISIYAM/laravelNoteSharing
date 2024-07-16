$(document).ready(function () {
    $(".hideAddFormModal").on("click", function () {
        $("#addFormModal").modal("hide");
    });
});

// dynamically add materials for pdf input field
$(".addInputPdf").on("click", function () {
    $(".dynamicPdf").append(
        '<div class="d-flex">' +
            '<div class="form-group">' +
            '<input type="file" name="pdfs[]" class="form-control-file" id="exampleFormControlFile1" />' +
            "</div>" +
            '<button type="button" class="removePdfInput badge bg-danger">Remove</button>' +
            "</div>"
    );
});

$(document).on("click", ".removePdfInput", function () {
    $(this).parent().remove();
});
