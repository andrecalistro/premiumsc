$(".select-payment").on('change', function(){
    loading('Carregando forma de pagamento');
    $("#choose-payment").submit();
});