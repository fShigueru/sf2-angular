function openImage(idImage, foto){
    jQuery(".modal-" + idImage).trigger("click");
    jQuery(".modal-body img").attr("src","");
    jQuery(".modal-body img").attr("src",foto);
};