import '../util/constants';


//post reutilizable
const post = async (URL_LOGIN, data) => {
  try{
    const response = await fetch(URL_LOGIN, {
      method: 'DELETE',
      
      body: JSON.stringify(data),
      // body: data,
      headers: {
        // 'Content-Type': 'application/json',
        // 'mode' : 'no-cors'
      },
    });
    //respuesta
    const resp = await response.json();
    if(response.status === 200){
      return resp;
    }else{
      throw(resp.message);
    }
  }
  catch (error) {
    console.log('fetch failed', error);
  }
};


export default post;