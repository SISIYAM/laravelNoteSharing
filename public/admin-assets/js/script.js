$(document).ready(function () {
    $(".hideAddFormModal").on("click", function () {
        $("#addFormModal").modal("hide");
    });
    // dynamically add materials for pdf input field
    $(document).on("click", ".addInputPdf", function () {
        $(".dynamicPdf").append(
            ' <div class=""><hr>' +
                '<div class="form-group"><input type="text" placeholder="Enter title" name="titlesPdf[]"' +
                'class="form-control my-2">' +
                '<input type="file" name="pdfs[]" class="form-control-file" id="exampleFormControlFile1" />' +
                "</div>" +
                '<button type="button" class="removePdfInput badge bg-danger">Remove</button>' +
                "</div>"
        );
    });

    // dynamically add materials for drive link input field
    $(document).on("click", ".addInputDrive", function () {
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

    $(document).on("change", "#modelFileType", () => {
        let value = $("#modelFileType").val();

        if (value == "pdf") {
            $("#modelDrive").hide();
            $("#modelPdf").show();
        }
        if (value == "drive") {
            $("#modelPdf").hide();
            $("#modelDrive").show();
        }
    });

    // update university form
    $(document).on("click", ".editSemesterBtn", function () {
        $(this).siblings("input").prop("readonly", false);
        $(this).hide();
        $(this).siblings(".cancelEditSemesterBtn").show();

        // trigger save button after pressed enter
        $($(this).siblings("input")).keypress(function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                $(this).siblings(".cancelEditSemesterBtn").click();
            }
        });
    });

    $(document).on("click", "#addDynamicSemesterBtn", function () {
        const newField = `<div class="mb-3"><input type="text" name="newSemester[]" id="" class="form-control" placeholder="Enter" aria-describedby="helpId" />
    <button class="badge bg-danger my-1 removeDynamicSemester">Remove</button><hr></div>`;
        $("#dynamicSemester").show();
        $("#dynamicSemesterAppend").append(newField);
    });

    $(document).on("click", ".removeDynamicSemester", function () {
        $(this).parent().remove();
    });

    // select all checkbox
    $(document).on("click", "#selectAll", function () {
        if ($("#selectAll").is(":checked")) {
            $(".isCheck").prop("checked", true).triggerHandler("click");
        } else {
            $(".isCheck").prop("checked", false).triggerHandler("click");
        }
        checkBoxCount();
    });

    // checkbox
    $(document).on("click", ".isCheck", function () {
        checkBoxCount();
    });
});

// functions

// this function count checked checkbox and hide and show delete btn
const checkBoxCount = () => {
    let checked = [];
    $(".isCheck:checked").each(function () {
        checked.push($(this).val());
    });

    if (jQuery.isEmptyObject(checked)) {
        $("#selectedDeleteBtn").hide();
        $("#checkedCount").html("");
    } else {
        $("#checkedCount").html(`Selected item ${checked.length}`);
        $("#selectedDeleteBtn").show();
    }
};
