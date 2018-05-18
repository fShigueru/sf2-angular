function initVitrine(vitrines){
    jQuery("#slideshow").vegas({
        slides: vitrines,
        transition: ['fade2','swirlLeft','fade','zoomOut'],
        delay: 7000,
        transitionDuration: 7000,
        overlay: true,
        align: 'bottom'
    })('overlay');
};