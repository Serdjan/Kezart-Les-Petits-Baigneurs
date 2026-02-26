<!DOCTYPE html>
<html <?php
        language_attributes(); ?> class="subpixel-antialiased leading-normal scroll-smooth">

<head>
    <!-- Meta -->
    <meta charset="<?php
                    bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
    <!-- Other -->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php
                                bloginfo('pingback_url'); ?>">

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe0Ol9v5t7zzA98k_nPMXHDABrca5RwHU">
    </script>

    <?php
    wp_head(); ?>
</head>

<body x-data="{mobileMenu: false}" <?php
                                    body_class('bg-[#E8EDFE] font-sans pt-4 md:pt-13'); ?>>
    <?php
    wp_body_open(); ?>

    <header class="container sticky z-10 top-0">
        <div class="bg-blue rounded-full px-7 py-2.5 flex items-center justify-between gap-x-7">
            <div class="inline-flex items-center gap-x-7">
                <a href="<?php
                            echo esc_url(home_url('/')); ?>">
                    <svg width="68" height="50" viewBox="0 0 68 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M37.6213 27.0397C36.9381 27.7845 34.9915 29.1023 34.682 29.8984C34.4218 30.5686 34.7728 31.0236 35.4272 31.0718C37.6129 31.2331 41.8686 26.8728 43.6306 25.5108C45.003 17.9915 47.0904 7.26201 52.7782 2.01C56.3174 -1.25806 61.1178 -0.327079 61.8479 4.98913C62.4781 9.58143 59.7787 13.7395 57.1655 17.0838C54.3587 20.6761 51.0427 23.9153 47.7055 26.9426C47.5451 27.2187 47.7055 27.6801 47.8031 27.9731C49.3094 32.4907 54.0182 26.9105 55.5805 25.2668C56.5202 24.2789 58.3987 21.713 59.7772 21.713C62.2398 21.713 60.7372 25.5662 62.2413 26.4618C63.3731 27.136 64.6297 26.2427 65.6768 25.8639C67.7944 25.0983 67.134 26.457 66.096 27.4305C64.4391 28.9851 60.9302 30.835 59.703 27.7885C59.5381 27.3792 59.3656 26.3198 59.2044 26.0726C58.9427 25.6729 58.2678 26.2901 58.0454 26.5156C56.4385 28.1456 55.2083 30.4659 53.4614 32.1617C50.6054 34.9346 46.1954 36.4129 44.3448 31.6376C44.1844 31.2243 44.105 30.6681 43.9438 30.2957C43.9174 30.2339 43.931 30.1432 43.8145 30.1962C43.6851 30.2556 42.9255 31.0156 42.7084 31.1898C40.1845 33.2139 33.5593 37.8094 31.2313 33.4273C29.9051 30.9297 31.8252 29.4626 32.8179 27.5236C33.9988 25.2171 31.5188 25.5357 30.3832 26.6272C27.4803 29.4161 26.8085 35.5686 27.5446 39.4201C28.025 41.9338 29.6463 45.1472 29.8544 47.396C30.0814 49.8495 27.7338 50.6633 26.1117 49.2781C22.2426 45.9755 23.0506 36.2163 24.187 31.6858C24.5562 30.2147 25.2447 28.6087 25.5201 27.1657C25.943 24.9522 24.8339 26.014 24.0659 26.9081C21.5315 29.8591 18.5067 35.4065 14.0158 34.5951C10.5091 33.9618 9.96289 29.4442 9.95684 26.3479C6.91849 27.8872 2.4525 28.1705 0.590606 24.6079C0.208543 23.8768 -0.302893 21.8045 0.344724 21.1721C0.894744 20.6352 1.42585 21.8439 1.6793 22.1713C3.92402 25.071 7.83317 23.6561 10.2595 21.8174C10.4062 21.0309 10.5076 20.2347 10.6748 19.4514C11.8059 14.1633 15.998 4.10631 20.3573 1.08785C22.9069 -0.676999 26.577 -0.412954 27.8132 2.89202C29.3611 7.03167 26.7487 11.7949 24.3292 14.9193C21.3665 18.7443 17.6057 21.9891 13.8531 24.9041C13.7563 27.5806 14.5477 30.9217 17.7502 29.1143C20.1628 27.7524 24.069 22.1167 26.3349 21.8559C26.7699 21.8061 27.2397 21.8671 27.6241 22.0943C28.9919 22.9 28.283 24.758 30.6828 23.8182C32.8572 22.9675 36.9335 19.693 38.691 22.7933C39.5929 24.384 38.6804 25.8832 37.619 27.0405L37.6213 27.0397ZM14.1951 19.6103C14.3267 19.6472 14.3464 19.5517 14.4221 19.4907C15.2687 18.8094 16.2015 17.9273 16.9951 17.1665C19.0863 15.1609 23.7247 10.3142 23.9532 7.30213C24.0455 6.08785 23.407 4.88319 22.1186 5.11754C20.4042 5.42894 18.1254 9.38881 17.3326 10.9498C15.9632 13.6464 14.8904 16.6392 14.1951 19.6111V19.6103ZM48.1647 21.2941C49.9146 19.5036 51.6237 17.5638 53.1557 15.559C54.5622 13.7179 57.7065 9.37998 57.4613 6.98994C57.3652 6.05093 56.6722 5.30534 55.7432 5.55334C54.0636 6.00117 51.9664 10.3968 51.2522 12.0188C49.9449 14.9891 48.9477 18.124 48.1647 21.2941Z"
                            fill="white" />
                    </svg>
                </a>
                <?php
                wp_nav_menu(
                    ['theme_location' => 'primary', 'container' => 'nav', 'menu_class' => 'header-menu']
                ); ?>
            </div>
            <div>
                <button type="button" @click="mobileMenu = true"
                    class="md:hidden text-white size-[50px] flex items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <?php
                wp_nav_menu(
                    ['theme_location' => 'secondary', 'container' => 'nav', 'menu_class' => 'header-menu']
                ); ?>
            </div>
        </div>
    </header>

    <div x-dialog x-model="mobileMenu" x-cloak class="fixed inset-0 overflow-hidden z-10">
        <!-- Overlay -->
        <div x-dialog:overlay x-transition.opacity class="fixed inset-0 bg-black/25"></div>

        <!-- Panel -->
        <div class="fixed inset-y-0 right-0 max-w-lg w-full max-h-dvh min-h-dvh">
            <div x-dialog:panel x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full" class="h-full w-full">
                <div class="h-full flex flex-col bg-blue shadow-lg overflow-y-auto py-12 px-10">
                    <!-- Close Button -->
                    <div class="absolute right-0 top-0 mr-2 mt-2">
                        <button type="button" @click="$dialog.close()"
                            class="relative inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md bg-transparent p-1.5 font-medium text-white hover:bg-blue-dark cursor-pointer">
                            <span class="sr-only">Close modal</span>
                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path
                                    d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <?php
                    wp_nav_menu(
                        [
                            'theme_location' => 'primary',
                            'container' => 'nav',
                            'menu_class' => 'header-menu header-menu--mobile'
                        ]
                    ); ?>

                    <div class="mt-auto">
                        <?php
                        wp_nav_menu(
                            [
                                'theme_location' => 'secondary',
                                'container' => 'nav',
                                'menu_class' => 'header-menu header-menu--mobile'
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>