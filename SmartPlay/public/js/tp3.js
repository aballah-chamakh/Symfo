

const tp3_table = $("#accordion") ;
function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
      currentDate = Date.now();
    } while (currentDate - date < milliseconds);
  }
if(tp3_table){
    tp3_table.on('click',e=>{
        if(e.target.className === 'btn btn-link'){
            let target = e.target.getAttribute("data-target") ;
            let targetChild = $(target)[0].firstElementChild ;
           
            let target_id = target.split('_')[1] ;
            console.log($("#loader_"+target_id));
            
            if($("#loader_"+target_id).length > 0){
                console.log("here")
                $("#loader_"+target_id).remove();
                console.log("any");
                $(targetChild).append("<h1 id='any'>Hello world</h1>") ;
            }else if($("#any").length == 0){
                console.log("any");
                $(targetChild).append("<h1 id='any'>Hello world</h1>") ;
                //$("#loader_"+target_id).parent().append("<h1>Hello world</h1>") ;
            }
            
           // let loader = $('loa')
            let nb = 7 ; 
            console.log(nb)
            fetch("/tp3/answer_question/?question_nb="+nb,{
                method : "GET" ,
            }).then(res=>{
                res.json().then((data) => {
                    console.log(data) ;
                });
            })      
        }

    })
}