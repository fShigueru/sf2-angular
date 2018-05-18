function readURL(input,configuracao) {
    if (input.files && input.files[0]) {
        var resultado = true;
        var reader = new FileReader();
        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;
            image.onload = function() {
                // access image size here
                console.log(this.width);
                console.log(this.height);
                if(this.width < configuracao.minWidth){
                    alert("A largura da imagem é menor que a esperada");
                    resultado = false;
                }
                if(this.width > configuracao.maxWidth){
                    alert("A largura da imagem é maior que a esperada");
                    resultado = false;
                }
                if(this.height < configuracao.minHeight){
                    alert("A altura da imagem é menor que a esperada");
                    resultado = false;
                }
                if(this.height > configuracao.maxHeight){
                    alert("A altura da imagem é maior que a esperada");
                    resultado = false;
                }
                if(resultado){
                    jQuery('#foto').attr('src', e.target.result);
                    jQuery(".profile_img").show();
                }
            };
        };
        if(resultado) {
            reader.readAsDataURL(input.files[0]);
        }
    };
};