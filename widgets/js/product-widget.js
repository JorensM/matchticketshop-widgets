function getLastUrlSegment(url) {
  return new URL(url).pathname.split('/').filter(Boolean).pop();
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

// Render functions

function renderInfo()

const product_slug = getLastUrlSegment(window.location.href);

const url = "https://www.matchticketshop.com/wp-json/wc/v3/products/?slug=" + product_slug;

const public_key = "ck_3a8304f13c13bde4ade25d749ebd4227034877f0";
const private_key = "cs_4ee08ab9223aaee0060de1c4924d7a02449f99e7";

//Data

ticket_qty = 0;

const checkout_url = getCookie("checkout_url");

console.log(checkout_url);

const request = new Request(url, {
  headers: {
    "Content-Type": "application/json",
    'Accept': 'application/json',
    "Authorization": " Basic " + base64(public_key + ":" + private_key)
  }
})

console.log(request);

console.log("fetching...");
fetch(request)
  .then(response => response.json())
  .then(product => {
    //console.log("data");
    //console.log(data);
  })
  .catch(err => {
    console.log("fetch err");
    console.log(err);
  });

