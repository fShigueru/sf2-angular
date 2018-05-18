angular.module("appAdmin").service("slugService", function (Slug) {
    this.getSlug = function (texto) {
        return Slug.slugify(texto);
    }
});