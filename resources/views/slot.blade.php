@extends('layouts.main')
@section('content')


<div id="stage">
        <div id="rotate">
            <div id="ring1" class="ring"></div>
            <div id="ring2" class="ring"></div>
            <div id="ring3" class="ring"></div>
        </div>
        <button class="go">Start spinning</button>
    </div>

    <script>
        const SLOTS_PER_REEL = 12;
        // console.log(this.radius);
        // current settings give a value of 149, rounded to 150
        const REEL_RADIUS = 150;
        var spinners = [];
        function createSlots(ring, num) {

            var slotAngle = 360 / SLOTS_PER_REEL;
            var seed = getSeed();
            for (var i = 0; i < SLOTS_PER_REEL; i++) {
                var slot = document.createElement('div');

                slot.className = 'slot';
                spinners.push(slot);
                // compute and assign the transform for this slot
                var transform = 'rotateX(' + (slotAngle * i) + 'deg) translateZ(' + REEL_RADIUS + 'px)';

                slot.style.transform = transform;
                // setup the number to show inside the slots
                // the position is randomized to 
                var content = $(slot).append('<p>' + ((seed + i) % 12) + '</p>');

                // add the poster to the row
                ring.append(slot);
            }
        }
        function getSeed() {
            // generate random number smaller than 13 then floor it to settle between 0 and 12 inclusive
            return Math.floor(Math.random() * (SLOTS_PER_REEL));
        }
        function spin(timer) {
            spinners.forEach(e => {
                e.style.background = 'none';
            });
            setTimeout(() => {
                var win = {};
                for (var i = 1; i < 4; i++) {
                    var oldSeed = -1;

                    var oldClass = $('#ring' + i).attr('class');
                    if (oldClass.length > 4) {
                        oldSeed = parseInt(oldClass.slice(10));
                    }
                    var seed = getSeed();
                    while (oldSeed == seed) {
                        seed = getSeed();
                    }

                    $('#ring' + i)
                        .css('animation', 'back-spin 1s, spin-' + seed + ' ' + (timer) + 's')
                        .attr('class', 'ring spin-' + seed);
                }
            }, 0)
        }

        function endSpin() {
            let w = [];
            spinners.forEach(e => {
                let y = Math.round(e.getBoundingClientRect().y);
             
                if (y === 197) {
                    w.push({ n: e.innerText, e });
                }
            });
            if (w[0].n == w[1].n && w[1].n == w[2].n) {
                w[0].e.style.background = 'green';
                w[1].e.style.background = 'green';
                w[2].e.style.background = 'green';
            } else {
                w[0].e.style.background = 'red';
                w[1].e.style.background = 'red';
                w[2].e.style.background = 'red';
            }
            return w;
        }

        $(document).ready(function () {
            // initiate slots 
            createSlots($('#ring1'), 1);
            createSlots($('#ring2'), 2);
            createSlots($('#ring3'), 3);
            // hook start button
            $('.go').on('click', function () {
                var timer = 2;
                spin(timer);
                setTimeout(() => {
                    var res = endSpin();
                    console.log(res[0].n);
                    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/",
                    data: {
                        'res1' : res[0].n,
                        'res2' : res[1].n,
                        'res3' : res[2].n,
                    },
                    type:'post',
                    success: function (response) {
        
                    }
                    });
                }, timer * 1000)
            })
        });
        document.onkeyup = (e) => {
            if (e.code === 'Space') {
                spin(2)
                setTimeout(() => {
                    endSpin();
                }, 2000)
            }
        }
    </script>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #stage {
            margin: 0 auto;
            width: 600px;
            padding: 0 0 40px;
        }

        #rotate {
            margin: 0 auto 0;
            width: 450px;
            height: 220px;
            padding-top: 200px;
            /* Ensure that we're in 3D space */
            transform-style: preserve-3d;
        }

        .ring {
            margin: 0 auto;
            height: 80px;
            width: 90px;
            float: left;
            transform-style: preserve-3d;
        }

        .slot {
            position: absolute;
            width: 90px;
            height: 80px;
            box-sizing: border-box;
            opacity: 0.9;
            color: rgba(0, 0, 0, 0.9);
            background: #fff;
            border: solid 2px #000;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .backface-on {
            -webkit-backface-visibility: visible;
            -moz-backface-visibility: visible;
            backface-visibility: visible;
        }

        .slot p {
            font-size: 36px;
            font-weight: bold;
            line-height: 80px;
            margin: 0;
            text-align: center;
        }

        .go {
            display: block;
            margin: 0 auto 20px;
            padding: 10px 30px;
            font-size: 20px;
            cursor: pointer;
        }

        label {
            cursor: pointer;
            display: inline-block;
            width: 45%;
            text-align: center;
        }

        /*=====*/
        .spin-0 {
            transform: rotateX(-3719deg);
        }

        .spin-1 {
            transform: rotateX(-3749deg);
        }

        .spin-2 {
            transform: rotateX(-3779deg);
        }

        .spin-3 {
            transform: rotateX(-3809deg);
        }

        .spin-4 {
            transform: rotateX(-3839deg);
        }

        .spin-5 {
            transform: rotateX(-3869deg);
        }

        .spin-6 {
            transform: rotateX(-3899deg);
        }

        .spin-7 {
            transform: rotateX(-3929deg);
        }

        .spin-8 {
            transform: rotateX(-3959deg);
        }

        .spin-9 {
            transform: rotateX(-3989deg);
        }

        .spin-10 {
            transform: rotateX(-4019deg);
        }

        .spin-11 {
            transform: rotateX(-4049deg);
        }

        @keyframes spin-0 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3719deg);
            }
        }

        @keyframes spin-1 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3749deg);
            }
        }

        @keyframes spin-2 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3779deg);
            }
        }

        @keyframes spin-3 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3809deg);
            }
        }

        @keyframes spin-4 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3839deg);
            }
        }

        @keyframes spin-5 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3869deg);
            }
        }

        @keyframes spin-6 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3899deg);
            }
        }

        @keyframes spin-7 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3929deg);
            }
        }

        @keyframes spin-8 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3959deg);
            }
        }

        @keyframes spin-9 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-3989deg);
            }
        }

        @keyframes spin-10 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-4019deg);
            }
        }

        @keyframes spin-11 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-4049deg);
            }
        }

        @keyframes spin-12 {
            0% {
                transform: rotateX(30deg);
            }

            100% {
                transform: rotateX(-4079deg);
            }
        }
    </style>

@endsection