$(document).ready(function () {
    $(".hideAddFormModal").on("click", function () {
        $("#addFormModal").modal("hide");
    });
});

// dynamically add materials for pdf input field
$(".addInputPdf").on("click", function () {
    $(".dynamicPdf").append(
        ' <div class="d-flex"><hr>' +
            '<div class="form-group"><input type="text" placeholder="Enter title" name="titlesPdf[]"' +
            'class="form-control my-2">' +
            '<input type="file" name="pdfs[]" class="form-control-file" id="exampleFormControlFile1" />' +
            "</div>" +
            '<button type="button" class="removePdfInput badge bg-danger">Remove</button>' +
            "</div>"
    );
});

// dynamically add materials for drive link input field
$(".addInputDrive").on("click", function () {
    $(".dynamicDrive").append(
        '<div class=""><hr>' +
            '<div class="form-group"><input type="text" placeholder="Enter title" name="titlesDrive[]"' +
            'class="form-control my-2">' +
            '<input type="text" name="links[]" class="form-control" placeholder="Paste Google Drive link" />' +
            "</div>" +
            '<button type="button" class="removePdfInput badge bg-danger my-2">Remove</button>' +
            "</div>"
    );
});

$(document).on("click", ".removePdfInput", function () {
    $(this).parent().remove();
});

$(document).on("change", "#fileType", () => {
    let value = $("#fileType").val();

    if (value == "pdf") {
        $("#driveFile").hide();
        $("#pdfFile").show();
    }
    if (value == "drive") {
        $("#pdfFile").hide();
        $("#driveFile").show();
    }
});
