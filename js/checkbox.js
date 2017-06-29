$(function(){
    var tbl = $("#checklistInfo");
    var head = tbl.find('thead');
    var buttonCountUpdate = function(){
      $(['.done','.enrolled']).each(function(i,e){
        var cl = e;
        var btn = tbl.find(".dept-detail "+ cl +" input:checkbox");
        var t= btn.length , s= btn.filter(":checked").length;
        tbl.find("thead "+ cl +" .count .total").html( t );
        tbl.find("thead "+ cl +" .count .selected").html( s );
        tbl.find('.firstyear-firstsem').each(function(i,e){
          var nm = $(this);
          var det = nm.next(".dept-detail");
          var btn = det.find(cl + " input:checkbox");
          var t= btn.length , s= btn.filter(":checked").length;
          nm.find(cl + " .count .total").html( t );
          nm.find(cl + " .count .selected").html( s );
        });
      });
    };
    tbl.on( "update", buttonCountUpdate)
    .delegate("thead .enrolled input:checkbox","change", function(){
      tbl.find(".dept-detail .enrolled input:checkbox, .dept-name .enrolled input:checkbox").prop("checked", $(this).is(":checked"));
      if($(this).is(":checked")){
        tbl.find(".dept-detail .done input:checkbox, .dept-name .done input:checkbox").prop("checked", !$(this).is(":checked"));
      }
    })
    .delegate("thead .done input:checkbox", "change", function(){
      tbl.find(".dept-detail .done input:checkbox, .dept-name .done input:checkbox").prop("checked", $(this).is(":checked"));
      if($(this).is(":checked")){
        tbl.find(".dept-detail .enrolled input:checkbox, .dept-name .enrolled input:checkbox").prop("checked", !$(this).is(":checked"));
      }
    })
    .delegate(".dept-name .enrolled input:checkbox", "change", function(){
      var det = $(this).parents('.dept-name').next('.dept-detail');
      var name = $(this).parents(".dept-name");
      det.find(".enrolled input:checkbox").prop("checked", $(this).is(":checked"));
      if(!$(this).is(":checked")){
         tbl.find("thead .enrolled input:checkbox").prop("checked", false);
      }
    })
    .delegate(".dept-name .done input:checkbox", "change", function(){
      var det = $(this).parents('.dept-name').next('.dept-detail');
      var name = $(this).parents(".dept-name");
      det.find(".done input:checkbox").prop("checked", $(this).is(":checked"));
      if(!$(this).is(":checked")){
        tbl.find("thead .done input:checkbox").prop("checked", false);
      }
    })
    .delegate(".dept-detail .done input:checkbox", "change", function(e){
      var v = $(this).parents(".dept-detail").find(".done input:checkbox");
      $(this).parents(".dept-detail").prev(".dept-name").find(".done input:checkbox").prop("checked", v.length == v.filter(":checked").length);
      v = tbl.find(".dept-detail .done input:checkbox");
      head.find(".done input:checkbox").prop("checked",v.length == v.filter(":checked").length);
    })
    .delegate(".dept-detail .enrolled input:checkbox", "change", function(){
      var v = $(this).parents(".dept-detail").find(".enrolled input:checkbox");
      $(this).parents(".dept-detail").prev(".dept-name").find(".enrolled input:checkbox").prop("checked", v.length == v.filter(":checked").length);
      v = tbl.find(".dept-detail .enrolled input:checkbox");
      head.find(".enrolled input:checkbox").prop("checked",v.length == v.filter(":checked").length);


    })
    .delegate(".enrolled input:checkbox", 'change', function(){
      var btn = $(this);
      var obtn = btn.parents("tr").find('.done input:checkbox');
      var chk = btn.is(":checked");
      if(chk){
        obtn.prop("checked", false).change();
      }
      tbl.trigger("update");
    })
    .delegate(".done input:checkbox", 'change', function(){
      var btn = $(this);
      var obtn = btn.parents("tr").find('.enrolled input:checkbox');
      var chk = btn.is(":checked");
      if(chk){
        obtn.prop("checked", false).change();
      }
      tbl.trigger("update");
    })
    ;
    tbl.trigger("update");
  });