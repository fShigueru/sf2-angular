angular.module("appAdmin").service("postService", function ($http) {
    this.postService = function (data,url) {
        return $http.post('/admin/' + url,data)
    }
});