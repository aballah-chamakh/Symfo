

const tp3_table = $("#accordion") ;

    $(document).on('click',e=>{
        if(e.target.className === 'btn btn-link'){
            let target = e.target.getAttribute("data-target") ;
            let targetChild = $(target)[0].firstElementChild ;
            let target_id = parseInt(target.split('_')[1]) ;

            console.log("target_id : "+target_id);
            if($("#loader_"+target_id).length > 0){
            fetch("/tp3/answer_question/?question_nb="+target_id,{
                method : "GET" ,
            }).then(res=>{
                res.json().then((data) => {
                    console.log(data) ;
                    $("#loader_"+target_id).remove();

                    let keys = Object.keys(data.data[0]) ;
                    let tabel = "<table class='table table-dark'><thead><tr>"
                    keys.map(key=>{
                        tabel += "<th scope='col'>"+key+"</th>"
                    })
                    tabel += "</tr></thead><tbody><tr>"
                    data.data.map(data_x =>{
                        tabel += "<tr>"
                        keys.map(key=>{
                            tabel += "<td>"+data_x[key]+"</td>"
                        })
                        tabel += "</tr>"
                    })  
                    tabel += "</tbody></table>"

                    $(targetChild).append(tabel) ;
                });
            })
        }      
        }

    })
