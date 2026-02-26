import ui from "@alpinejs/ui";
import focus from "@alpinejs/focus";
import collapse from "@alpinejs/collapse";
import Alpine from "alpinejs";
import Swiper from 'swiper/bundle';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, SplitText);

window.Alpine = Alpine;
Alpine.plugin(ui);
Alpine.plugin(focus);
Alpine.plugin(collapse);

Alpine.data("poolsApp", () => ({
    pools: [],
    cities: [],
    fullMap: false,
    courseTypes: [
        { id: 1, name: "Petit Baigneurs" },
        { id: 2, name: "Adultes" },
    ],
    filters: {
        city: null,
        courseType: null,
        order: "asc",
    },
    view: "list",
    map: null,
    markers: [],
    poolMapPopup: false,
    init() {
        this.$watch("filters.courseType", () => this.fetchPools());
        this.$watch("filters.city", () => this.fetchPools());
        this.$watch("filters.order", () => this.fetchPools());
        this.fetchPools(true);
    },

    getCourseTypeName(id) {
        const type = this.courseTypes.find((t) => t.id === id);
        return type?.name;
    },

    fetchPools(isInit) {
        const params = new URLSearchParams();
        if (this.filters.city) params.append("city", this.filters.city);
        if (this.filters.courseType?.id) {
            params.append("course_type", this.filters.courseType.id);
        }
        if (this.filters.order) params.append("order_by", this.filters.order);

        fetch(`/wp-json/lpb/v1/pools?${params.toString()}`)
            .then((res) => res.json())
            .then((data) => {
                this.pools = data;

                if (isInit) {
                    this.cities = [
                        ...new Set(data.map((pool) => pool.location.city)),
                    ];
                }

                if (this.view === "map") {
                    this.$nextTick(() => this.initMap());
                }
            });
    },

    toggleView() {
        this.view = this.view === "list" ? "map" : "list";

        if (this.view === "map") {
            this.$nextTick(() => this.initMap());
        }
        if (this.view === "list") {
            this.fullMap = false;
        }
    },

    showPoolInfo(pool) {
        document.getElementById("popup-image").src = pool.image || "";
        document.getElementById("popup-title").textContent = pool.title || "";
        document.getElementById("popup-address").innerHTML =
            pool.location.name +
                "<br>" +
                pool.location.post_code +
                ", " +
                pool.location.city || "";
        document.getElementById("popup-more").setAttribute("href", pool.url);
    },

    initMap() {
        if (!window.google || !this.pools.length) return;

        const center = {
            lat: parseFloat(this.pools[0].location.lat ?? 48.85),
            lng: parseFloat(this.pools[0].location.lng ?? 2.35),
        };

        this.map = new google.maps.Map(document.getElementById("map"), {
            center,
            zoom: 10,
            disableDefaultUI: true,
        });

        this.markers.forEach((marker) => marker.setMap(null));
        this.markers = [];

        this.pools.forEach((pool) => {
            console.log(pool);
            const position = {
                lat: parseFloat(pool.location.lat),
                lng: parseFloat(pool.location.lng),
            };

            const marker = new google.maps.Marker({
                position,
                map: this.map,
                title: pool.title,
            });

            marker.addListener("click", () => {
                this.showPoolInfo(pool);
                this.poolMapPopup = true;
            });

            this.markers.push(marker);
        });
    },
}));

document.addEventListener("alpine:init", () => {
    const poolPricingCarousels = document.querySelectorAll(
        ".pool-pricing-carousel",
    );
    if (poolPricingCarousels.length > 0) {
        poolPricingCarousels.forEach((carousel) => {
            new Swiper(carousel, {
                loop: true,
                spaceBetween: 28,
                breakpoints: {
                    1280: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                    640: {
                        slidesPerView: 2,
                    },
                },
                navigation: {
                    nextEl: '.button-next',
                    prevEl: '.button-prev',
                },
            });
        });
    }

    function animateIn(selector, animation = "fadeInUp") {
        const settings = {
            fadeInUp: { y: 50, opacity: 0 },
            fadeInDown: { y: -50, opacity: 0 },
            fadeInLeft: { x: -50, opacity: 0 },
            fadeInRight: { x: 50, opacity: 0 },
            zoomIn: { scale: 0.8, opacity: 0 },
            bounceIn: { y: 100, opacity: 0, ease: "bounce.out" },
        };

        const anim = settings[animation] || settings.fadeInUp;

        gsap.utils.toArray(selector).forEach((el) => {
            gsap.from(el, {
                ...anim,
                duration: 1.5,
                ease: anim.ease || "power2.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 70%",
                    toggleActions: "play none none none",
                },
            });
        });
    }

    animateIn(".animate-fadeInUp", "fadeInUp");

    const animationLines = document.querySelectorAll(".animation-lines");
    if (animationLines.length > 0) {
        let split, animation;

        function setupLines() {
            split && split.revert();
            split = SplitText.create(".animation-lines", { type: "lines" });

            animation && animation.revert();
            animation = gsap.from(split.lines, {
                rotationX: -100,
                transformOrigin: "50% 50% -160px",
                opacity: 0,
                duration: 0.8,
                ease: "power3",
                stagger: 0.25,
            });
        }

        setupLines();
    }
});

Alpine.start();
