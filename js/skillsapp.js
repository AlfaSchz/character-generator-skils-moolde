
// Polygon
var character_stats_html = document.getElementById("skillsTextValues").children;

var numberOfSides = character_stats_html.length

var character_stats = {};
var character_stats_text = {};

//Initial stats_graphic
for (var i = 0; i < numberOfSides; i += 1){
    character_stats[character_stats_html[i].id] = character_stats_html[i].getAttribute('data-value');
    character_stats_text[character_stats_html[i].id] = character_stats_html[i].getAttribute('data-name-trans');
}


for (var i = 0; i < numberOfSides; i += 1){
    
    var character_stats_html_div_children = character_stats_html[i];

    var character_stats_html_div_span_children = character_stats_html_div_children.children;

    for(var j = 1; j < 11; j +=1){
        
        var feelingClick = character_stats_html_div_span_children[j];
        
        feelingClick.addEventListener('click', function(event) {
            var value = this.getAttribute('data-value');
            var feeling = this.getAttribute('data-name');
            character_stats[feeling] = value;
            
            document.getElementById('input_' + feeling).value = value;
            
            
            //buttons background
            for(var k = 1; k < 11; k++){
                var character_stats_html_span = document.getElementById(feeling + k);
                if (k < Number(value) + 1){
                    character_stats_html_span.style.backgroundColor = "rgba(0, 0, 255, 0.5)";
                }else{
                    character_stats_html_span.style.backgroundColor = "rgba(0, 0, 255, 0.2)"; 
                }
            }
            
            //clear and redraw graphic
            var ctx = canvasGraph.getContext('2d');
            ctx.clearRect(0, 0, canvasGraph.width, canvasGraph.height);
            
            drawStatsGraphic(character_stats);
            drawGraphText(character_stats_text);
           
            
        }, false);

    }    
    
}





function buttonsBackground(character_stats_arg){

    for(var key in character_stats_arg){
        
        var value = character_stats_arg[key];

        for(var k = 1; k < Number(value) + 1; k++){

            var character_stats_html_span = document.getElementById(key + value);

            character_stats_html_span.style.backgroundColor = "rgba(0, 0, 255, 0.5)";
            
        }

    }

}



//var canvasSkills = document.getElementById('characterCanvasSkills');
var canvasGraph = document.getElementById('characterCanvasGraph');

var numberOfSides = Object.keys(character_stats).length,
    size = canvasGraph.width*0.21,
    Xcenter = canvasGraph.width/2,
    Ycenter = canvasGraph.height/2,
    textSize = canvasGraph.width*0.037,
    textFont = 'Arial';

//draw graphic 
function drawGraphText(character_stats_text_arg){
    
    for (var j = 1; j <= 10;j += 1){
        var cxt = canvasGraph.getContext('2d');
        cxt.beginPath();
        cxt.moveTo (Xcenter +  size * j/10 * Math.cos(0), Ycenter +  size * j/10 *  Math.sin(0));          

        for (var i = 1; i <= numberOfSides;i += 1) {
            cxt.lineTo (Xcenter + size * j/10 * Math.cos(i * 2 * Math.PI / numberOfSides), Ycenter + size * j/10 * Math.sin(i * 2 * Math.PI / numberOfSides));
        }

        cxt.fillStyle = "#000000";
        cxt.strokeStyle = "#000000";
        cxt.lineWidth = 0.1;
        cxt.stroke();
    }
    
    var counter = 0;
    for(var attribute in character_stats_text_arg) {

        var text = canvasGraph.getContext("2d");
        text.font = textSize + 'px ' + textFont;
        
        textWidth = text.measureText(character_stats_text_arg[attribute]).width;
        var X_text = Xcenter + (size + textWidth/1.7) * Math.cos(counter * 2 * Math.PI / numberOfSides) - textWidth/2;
        var Y_text = Ycenter + (size + textSize)* Math.sin(counter * 2 * Math.PI / numberOfSides) + textSize/4;    

        text.fillText(character_stats_text_arg[attribute],X_text, Y_text);
        counter +=1;
    }

}

//draw stats

function drawStatsGraphic(character_stats_arg){
    var stats_graphic = canvasGraph.getContext('2d');
    stats_graphic.beginPath();

    counter = 0;
    for(var attribute in character_stats_arg) {
        var score = Number(character_stats_arg[attribute]);
        if(counter == 0){
            var Xfirst_point = Xcenter +  size * score/10 * Math.cos(0);
            var Yfirst_point = Ycenter +  size * score/10 * Math.sin(0);
            stats_graphic.moveTo (Xfirst_point, Yfirst_point);

        }
        
        var x = Xcenter + size * score/10 * Math.cos(counter * 2 * Math.PI / numberOfSides);
        var y = Ycenter + size * score/10 * Math.sin(counter * 2 * Math.PI / numberOfSides);
        
        stats_graphic.lineTo (x, y);
        
        counter +=1;
        
        if (counter == numberOfSides){
            stats_graphic.lineTo (Xfirst_point, Yfirst_point);
        }    
    }

    stats_graphic.fillStyle = "rgba(0, 0, 255, 0.5)";
    stats_graphic.fill();
}



(function init() {
    
drawGraphText(character_stats_text);
drawStatsGraphic(character_stats);
buttonsBackground(character_stats);

})();