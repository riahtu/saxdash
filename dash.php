<?php $place = $_GET['place']; echo("<h1>$place</h1>");?>
<!doctype html>

<html>
<head>
    <title>SAXDASH</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <style>
    body {
        text-align: center;
        background-image: url(bg.jpg);
        background-repeat: repeat;
        color: green;
        a: link {color red;}
    }

    p {
        display: block;
        width: 450px;
        margin: 2em auto;
        text-align: left;
    }
    </style>
</head>
<body>
<a href=index.html> back </a>


</body>
<script src="justgage/raphael-2.1.4.min.js"></script>
<script src="justgage/justgage.js"></script>

<script type="text/javascript">
// ON page load
//<div id="container">
//    <div id="g3"></div>
//    <div id="g0"></div>
//</div>


window.onload = function(){

    $.ajax({
        url:		'ajax.php',
        dataType:	'json',
        success:	initDash,
        type:		'GET',
        data:		{
            place: '<?php echo("$place")?>'
        }
    });

    var g = [];

    function initDash(result) {
        console.log(result['0']['1']);
        //console.log(result['0']['2']);
        var rr = result['0']['1']; // Number of items
        //var cc = result['0']['2']; // Number of parameters in each item
        var count;
        var metertype;
        for(count=1; count <= rr; count++)
        {
            var div = document.createElement('div');
            document.body.appendChild(div);
            var msgtype = result[count][3];
            var mt = msgtype.toString();
            var temp1 = "g";
            var did = temp1.concat(count);
            div.id = did;
            div.style.float = 'left';
            //div.style.backgroundColor = 'red';
            div.style.width  = '200px';
            div.style.height = '160px';
            //div.style.position = 'relative';
            //div.style.display = 'inline-block';
            console.log(msgtype);
            var title = "";
            //title = title.concat(' ');
            //title = title.concat(result[count]['1'])
            if(msgtype == '4')
            {
                title += "Temperatur - ";
                title += result[count]['5'];
                g[count] = new JustGage({
                    id: did,
                    value: 1,
                    min: 0,
                    max: 60,
                    decimals: 2,
                    title: title,
                    label: 'celcius',
                    labelFontColor: "#ffffff",
                    valueFontColor: "#ffffff"
                });
            }
            if(msgtype == '5')
            {
                title += "Luftfuktighet - ";
                title += result[count]['5'];
                g[count] = new JustGage({
                    id: did,
                    value: 1,
                    min: 30,
                    max: 100,
                    decimals: 2,
                    title: title,
                    label: 'hum%',
                    labelFontColor: "#ffffff",
                    valueFontColor: "#ffffff"
                });
            }
            if(msgtype == '6')
            {
                title += "Vikt - ";
                title += result[count]['5'];
                g[count] = new JustGage({
                    id: did,
                    value: 1,
                    min: 0,
                    max: 120,
                    title: title,
                    label: 'kg',
                    labelFontColor: "#ffffff",
                    valueFontColor: "#ffffff"
                });
            }
            if(msgtype == '8')
            {
                title += "El - ";
                title += result[count]['5'];
                g[count] = new JustGage({
                    id: did,
                    value: 1,
                    min: 0,
                    max: 8000,
                    pointer: true,
                    pointerOptions: {
                      toplength: -15,
                      bottomlength: 10,
                      bottomwidth: 12,
                      color: '#000000',
                      stroke: '#ffffff',
                      stroke_width: 3,
                      stroke_linecap: 'round'
                    },
                    gaugeWidthScale: 0.5,
                    counter: true,
                    hidevalue: true,
                    decimals: 1,
                    title: title,
                    label: 'watt',
                    labelFontColor: "#ffffff",
                    valueFontColor: "#ffffff"
                });
            }

        }

    }


    var tid = setInterval(getData, 5000);
    function getData() {
        console.log("Getting  data");
        $.ajax({
            url:		'ajax.php',
            dataType:	'json',
            success:	setData,
            type:		'GET',
            data:		{
                place: '<?php echo("$place")?>'
            }
        });
    }

    function setData(result)
    {
        //console.log("data!");
        //console.log(result);
        console.log(result['0']['1']);
        //console.log(result['0']['2']);
        var rr = result['0']['1']; // Number of items
        //var cc = result['0']['2']; // Number of parameters in each item
        var count;
        for(count=1; count <= rr; count++)
        {
            //console.log(result[count]['3']);
            //var intvalue = Math.round(result[count]['2']);
            var intvalue = result[count]['2'];
            g[count].refresh(intvalue);
        }
    }
}
</script>

</html>
