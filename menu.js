$(document).ready(function (){
    $("#searchBtnSubmit").click(function(){
        
        if($("#searchBtnInput").val() != ""){
            window.location.href = './menu.php?searchButton=' + $('#searchBtnInput').val();
        }else{
            $("#searchBtnInput").attr("placeholder", "Search Input cannot be blank");
        }
    });

})