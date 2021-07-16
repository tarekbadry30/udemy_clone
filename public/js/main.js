$(document).ready(function () {
    $(document).on("submit","form.ajax-form",function (e) {
        let currentForm=$(this);
        e.preventDefault();
        var formData = new FormData(this);
        var form= currentForm;
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data.errorNum==200){
                    currentForm.trigger('reset');
                    $(".reload-btn").click();
                    $(".modal.show").modal("hide");
                    if(currentForm.hasClass("mustRefresh")){
                        Swal.fire({
                            title: `${data.msg}`,
                            icon: "success",
                            timer: 1300,
                            showConfirmButton: true,

                            confirmButtonText: 'ok',
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1300);
                        return false;
                    }
                    Swal.fire({
                        title: `${data.msg}`,
                        icon: "success",
                        //timer: 1300,
                        showCloseButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'ok',
                    })


                }
                else if(data.errorNum==400){
                    var outputMessage='';
                    var errorMessage=data.msg;
                    for(i=0;i<data.errors.length;i++)
                        outputMessage+=`${data.errors[i]} \n  `;
                    Swal.fire({
                        title: `${errorMessage}`,
                        icon: "error",
                        text: `${outputMessage}`,
                        showConfirmButton: true,

                        confirmButtonText: 'ok',
                    });
                }
                else{
                    Swal.fire({
                        title: `${data.msg}`,
                        icon: "error",
                        //timer: 1300,
                        showConfirmButton: true,
                        confirmButtonText: 'ok',
                    });
                }
            }
        });
    });
});
