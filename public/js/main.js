if(document.getElementById('product_table') != null) {
    new Vue({
        delimiters: ['${', '}'],
      el: '#product_table',
      data:{
        blokBasicTable: true,
        blokXhrTable:false,
        blokEditProdukt:false,
        blokPagination : true,
        productList : "",
        order:"",
        produkt:"",
        activePage:0 
      },
      methods:{
        productListXhr(typ_produktu_id,vyrobce_id,order,from){
          var _order;
          _order = sessionStorage.getItem("order");
          if (_order === ""){
            if(order === ""){
              sessionStorage.setItem("order", "produkt_nazev");
              _order = "produkt_nazev";
            }
            else{
              sessionStorage.setItem("order", order);
              _order = order;
            }
           
          }
          else{
            if(order === ""){
              sessionStorage.setItem("order", _order);
            }
            else{
              sessionStorage.setItem("order", order);
              _order = order;
            }
          }
          try{
              (async () => {
                var _from = 0;
                if(from > 0){
                  _from = ((from * 10) - 10);
                }
                sessionStorage.setItem("from", from);
                this.activePage = sessionStorage.getItem("from");
                const response = await axios.get('/produkt-list/'+typ_produktu_id+'/'+vyrobce_id+'/'+_order+'/'+_from);
                this.blokBasicTable = false,
                this.blokXhrTable = true;
                this.blokPagination = true;
                this.productList = response.data[1];
                this.order = order;
              })();
    
            }catch(err){
              console.log(err)
            }
        },
        editProductFormXhr(e){
          var produkt_id = e.target.getAttribute("rel");
          try{
            (async () => {
              const response = await axios.get('/produkt-edit-form/'+produkt_id);
              this.blokBasicTable = false,
              this.blokXhrTable = false;
              this.blokPagination = false;
              this.blokEditProdukt = true;
              this.produkt = response.data[0];
            })();
  
          }catch(err){
            console.log(err)
          }
        },
        editProductXhr(e){
          var produkt_nazev = e.target.elements.produkt_nazev.value;
          var produkt_cena = e.target.elements.produkt_cena.value;
          var produkt_id = e.target.elements.produkt_id.value;
          var typ_produktu_id = e.target.elements.typ_produktu_id.value;
          var vyrobce_id = e.target.elements.vyrobce_id.value;
          var from;
          from = 0;
          if(this.activePage > 0){
            from = ((this.activePage * 10) - 10);
          }
          try{
            (async () => {
              const response = await axios.get('/produkt-edit/'+produkt_id+"/"+produkt_cena+"/"+produkt_nazev+"/"+typ_produktu_id+"/"+vyrobce_id+"/"+from);
              this.blokBasicTable = false,
              this.blokXhrTable = true;
              this.blokPagination = false;
              this.blokEditProdukt = false;
              this.productList = response.data[0];
            })();
          }catch(err){
            console.log(err)
          }

        }
      }
    })
}