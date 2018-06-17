var canvas = document.getElementById('characterCanvasBackground');
var canvasSkin = document.getElementById('characterCanvasSkin');
var canvasHair = document.getElementById('characterCanvasHair');
var canvasEyes = document.getElementById('characterCanvasEyes');
var canvasMouth = document.getElementById('characterCanvasMouth');
var canvasBody = document.getElementById('characterCanvasBody');
var canvasLegs = document.getElementById('characterCanvasLegs');
var canvasShoes = document.getElementById('characterCanvasShoes');
var canvasComplements = document.getElementById('characterCanvasComplements');

var objCanvas = {background:canvas,skin:canvasSkin,shoes:canvasShoes,legs:canvasLegs,body:canvasBody,eyes:canvasEyes,mouth:canvasMouth,hair:canvasHair,complements:canvasComplements};

var canvasWidth = canvas.width;
var canvasHeight = canvas.height;
var canvasRealWidth = canvas.offsetWidth;
var canvasRealHeight = canvas.offsetHeight;
var yY = canvasRealHeight/canvasHeight;
var xX = canvasRealWidth/canvasWidth;    

var canvasLeft = canvas.getBoundingClientRect().left - document.body.scrollLeft;
var canvasTop = canvas.getBoundingClientRect().top - document.body.scrollTop;


/**Set initial sprite**/

var objSprite = {};

var spans_sprite = document.getElementsByClassName("span_sprite");

for (span_sprite in spans_sprite) {
    if(spans_sprite[span_sprite].id){
        var name = spans_sprite[span_sprite].id;
        var value = parseInt(spans_sprite[span_sprite].getAttribute('data'));
        objSprite[name] = value;
    }
}
 

var canvasMenuElements = [];
var canvasSubMenuElements = [];


/***** Add event listener for `menu click` events.****/

var menu_imgs = document.getElementsByClassName("character_menu_item");

for (menu_img in menu_imgs) {
    var menuPart = menu_imgs[menu_img].id;
        if (menuPart){
            menu_imgs[menu_img].addEventListener('click', function(event) {
            var submenus = document.getElementsByClassName('subMenu');
            for (submenu in submenus){
                if(submenus[submenu].style){submenus[submenu].style.display = 'none';}
            }
            document.getElementById('subMenu_' + this.id.slice(20)).style.display = 'block';
        });
    }
}

/***** Add event listener for `submenu click` events.****/

var submenu_imgs = document.getElementsByClassName("subMenuItem");

for (submenu_img in submenu_imgs) {
    submenuPart = submenu_imgs[submenu_img].id;
        if (submenuPart){
            submenu_imgs[submenu_img].addEventListener('click', function(event) {
            var part = this.name; 
            var value = parseInt(this.getAttribute('value'));
            
            objSprite[part] = value;
            
            drawSpritePart(part,value)
            
            document.getElementById('input_' + part).value = value;
            
        });
    }
}

/***** Add event listener for `input name` events.****/
var nickName = document.getElementById("nickName");

nickName.addEventListener('change', function(event) {
        var value = this.value;
        console.log(value);
        document.getElementById('input_name').value = value;            
});


/**************sprite***************/

function drawSpritePart(spriteKey,spriteCode){

        var ctx = objCanvas[spriteKey].getContext('2d');
        
        ctx.clearRect(0, 0, 390, canvas.height);
                
        
        var sprite = new Image();
        
        sprite.onload = function(){
            var spriteWidth = sprite.width;
            var spriteHeight = sprite.height;
            
            var srcX = 0;
            var srcY = 0;
            var srcW = spriteWidth;
            var srcH = spriteHeight;
            var destX = 0;
            var destY = 0;
            var destW = canvasWidth;
            var destH = canvasHeight;
            
            ctx.drawImage(sprite,srcX,srcY,srcW,srcH,destX,destY,destW,destH);
            
        }
            
        sprite.src = '/mod/character/Resources/' + spriteKey + '/' + spriteKey + '_' + spriteCode + '.png';

}


function drawSprite(objSprite){
    for (key in objSprite) {
        drawSpritePart(key,objSprite[key]);
    }
}

(function init() {
    
drawSprite(objSprite);

})();


