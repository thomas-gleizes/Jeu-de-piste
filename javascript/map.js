function initMap() {
    var IUT = {lat: 43.635953, lng: 3.851412};
    // on créer la map google maps centré sur l'iut et avec sans aucun point d'intéret affiché
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 17.5, center: IUT, styles: [{
                "featureType": "poi",
                "stylers": [
                    { "visibility": "off" }
                ]
            }]});

    let markerTab = [];
    let nametab  = [];

    //inteval permettant de récupéré régulièrement les différent groupe et leurs localisations
    setInterval(function () {
        refreshLocalisation().then(function (value) {
            var tab3 = [];
            var tab = value.split('$');
            for (var i = 1; i < tab.length; i++) {
                var tab2 = tab[i].split(',');
                tab3.push(tab2[0]);
                if (!nametab.includes(tab2[0])){
                    nametab.push(tab2[0]);
                }
                //si le marker du goupe n'est pas déjà créé on le crée
                if (typeof markerTab[tab2[0]] == 'undefined') {
                    markerTab[tab2[0]] = new google.maps.Marker({
                        position: {lat: parseFloat(tab2[2]), lng: parseFloat(tab2[1])},
                        label: tab2[0],
                        map: map
                    });
                } else {
                    //sinon on change sa position
                    markerTab[tab2[0]].setPosition( new google.maps.LatLng( parseFloat(tab2[2]), parseFloat(tab2[1])));
                }
            }
            //si un marker sur la map n'est pas contenu dans le tableau de la requête ajax on le supprime
            for (var i = 0; i < nametab.length; i++) {
                if (!tab3.includes(nametab[i])){
                    markerTab[nametab[i]].setMap(null);
                }
            }
        });
    },100);


    //on crée ci-dessous tout les marker des batiment de l'iut
    var batA = new google.maps.Marker({
      position: {lat: 43.635441, lng: 3.850626},
      label: "A",
      map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
  });

    var batB = new google.maps.Marker({
        position: {lat: 43.635648, lng: 3.851464},
        label: "B",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batC = new google.maps.Marker({
        position: {lat: 43.635964, lng: 3.851679},
        label: "C",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batD = new google.maps.Marker({
        position: {lat: 43.636191, lng: 3.851177},
        label: "D",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batE = new google.maps.Marker({
        position: {lat: 43.636740, lng: 3.850555},
        label: "E",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batF = new google.maps.Marker({
        position: {lat: 43.636189, lng: 3.850611},
        label: "F",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batG = new google.maps.Marker({
        position: {lat: 43.636606, lng: 3.850160},
        label: "G",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batH = new google.maps.Marker({
        position: {lat: 43.636325, lng: 3.850050},
        label: "H",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });
    var batI = new google.maps.Marker({
        position: {lat: 43.635857, lng: 3.849533},
        label: "I",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batJ = new google.maps.Marker({
        position: {lat: 43.635379, lng: 3.849812},
        label: "J",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batK = new google.maps.Marker({
        position: {lat: 43.636249, lng: 3.853015},
        label: "K",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batL = new google.maps.Marker({
        position: {lat: 43.635605, lng: 3.852387},
        label: "L",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batL = new google.maps.Marker({
        position: {lat: 43.635605, lng: 3.852387},
        label: "L",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batM = new google.maps.Marker({
        position: {lat: 43.636727, lng:  3.851035},
        label: "M",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batN = new google.maps.Marker({
        position: {lat: 43.636141, lng:  3.853975},
        label: "N",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    var batO = new google.maps.Marker({
        position: {lat: 43.637096, lng:  3.849898},
        label: "O",
        map: map,
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
            labelOrigin: new google.maps.Point(30, 10),
            size: new google.maps.Size(32,32),
            anchor: new google.maps.Point(16,32)
        }
    });

    $("#retour").click(function () {
        document.location.href='../controller/routeur.php?Utilisateur=displayAcceuille';
    });


}
