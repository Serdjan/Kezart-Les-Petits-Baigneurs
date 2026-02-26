<?php

/**
 * Template Name: Pools
 */
declare(strict_types=1);

use RS\Theme\App\Helpers;

get_header();

$courses = new WP_Query([
    'post_type' => 'course',
    'posts_per_page' => -1,
    'post_status' => 'publish',
]);

Helpers::getPartialsFromBlueprints(); ?>

    <div id="main" class="container">
        <div x-data="poolsApp" class="relative pb-40">

            <div class="grid grid-cols-1 lg:grid-cols-2 mb-18 gap-6 lg:gap-0">
                <div class="flex flex-col md:flex-row md:items-center justify-between lg:justify-start gap-4 lg:gap-7">

                    <!-- City Filter -->
                    <div x-listbox x-model="filters.city" class="listbox">
                        <button x-show="filters.city !== null" @click="filters.city = null"
                                type="button" class="listbox__clear">Effacer la sélection
                        </button>
                        <label x-listbox:label class="sr-only">Ville</label>
                        <button x-listbox:button class="listbox-button">
                            <span class="truncate" x-text="filters.city || 'Choisir la ville'"></span>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 10.5L12 14.5L16 10.5" stroke="#111928" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <ul x-listbox:options x-cloak class="listbox-options">
                            <template x-for="city in cities" :key="city">
                                <li x-listbox:option :value="city" x-text="city" class="listbox-option" :class="{
                            'listbox-active': $listboxOption.isActive,
                            'listbox-selected': $listboxOption.isSelected
                        }"></li>
                            </template>
                        </ul>
                    </div>

                    <!-- Course Type Filter -->
                    <?php
                    if ($courses->have_posts()) : ?>
                        <div x-listbox x-model="filters.courseType" class="listbox">
                            <button x-show="filters.courseType !== null" @click="filters.courseType = null"
                                    type="button" class="listbox__clear">Effacer la sélection
                            </button>
                            <label x-listbox:label class="sr-only">Type de cours</label>
                            <button x-listbox:button class="listbox-button">
                                <span class="truncate"
                                      x-text="filters.courseType ? filters.courseType.title : 'Type de cours'"></span>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 10.5L12 14.5L16 10.5" stroke="#111928" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <ul x-listbox:options x-cloak class="listbox-options">
                                <?php
                                while ($courses->have_posts()) : $courses->the_post(); ?>
                                    <li
                                            x-listbox:option
                                            :value="{ id: <?php
                                            echo get_the_ID(); ?>, title: '<?php
                                            echo esc_js(get_the_title()); ?>' }"
                                            class="listbox-option"
                                            :class="{
                            'listbox-active': $listboxOption.isActive,
                            'listbox-selected': $listboxOption.isSelected
                        }"
                                    >
                                        <span><?php
                                            the_title(); ?></span>
                                    </li>
                                <?php
                                endwhile; ?>
                            </ul>
                        </div>
                        <?php
                        wp_reset_postdata(); ?>
                    <?php
                    endif; ?>
                </div>
                <div class="flex flex-col md:flex-row md:items-center justify-between lg:justify-end gap-4 lg:gap-2.5">
                    <!-- Order Filter -->
                    <div x-listbox x-model="filters.order" class="listbox">
                        <label x-listbox:label class="sr-only">Trier</label>
                        <button x-listbox:button class="listbox-button">
                            <span class="truncate" x-text="filters.order === 'asc' ? 'Nom (A-Z)' : 'Nom (Z-A)'"></span>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 10.5L12 14.5L16 10.5" stroke="#111928" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <ul x-listbox:options x-cloak class="listbox-options">
                            <li x-listbox:option value="asc" class="listbox-option">Nom (A-Z)</li>
                            <li x-listbox:option value="desc" class="listbox-option">Nom (Z-A)</li>
                        </ul>
                    </div>

                    <!-- Toggle View -->
                    <button @click="toggleView()"
                            class="flex items-center justify-between min-w-[150px] bg-white rounded-20 h-11 px-4 gap-4 cursor-pointer">
                        <span x-text="view === 'list' ? 'Liste et Carte' : 'Liste'"></span>
                        <svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                  d="M27 12.4551L27 7.20508C27 5.96289 25.9922 4.95508 24.75 4.95508L18.75 4.95508C17.5078 4.95508 16.5 5.96289 16.5 7.20508L16.5 12.4551C16.5 13.6973 17.5078 14.7051 18.75 14.7051L24.75 14.7051C25.9922 14.7051 27 13.6973 27 12.4551ZM15 16.2051L15 14.7051C15 13.4629 13.9922 12.4551 12.75 12.4551L5.25 12.4551C4.00781 12.4551 3 13.4629 3 14.7051L3 16.2051C3 17.4473 4.00781 18.4551 5.25 18.4551L12.75 18.4551C13.9922 18.4551 15 17.4473 15 16.2051Z"
                                  fill="#3D4BA8"/>
                            <path d="M27 23.7051C27 24.9473 25.9922 25.9551 24.75 25.9551L18.75 25.9551C17.5078 25.9551 16.5 24.9473 16.5 23.7051L16.5 18.4551C16.5 17.2129 17.5078 16.2051 18.75 16.2051L24.75 16.2051C25.9922 16.2051 27 17.2129 27 18.4551L27 23.7051ZM15 23.7051C15 24.9473 13.9922 25.9551 12.75 25.9551L5.25 25.9551C4.00781 25.9551 3 24.9473 3 23.7051L3 22.2051C3 20.9629 4.00781 19.9551 5.25 19.9551L12.75 19.9551C13.9922 19.9551 15 20.9629 15 22.2051L15 23.7051ZM12.75 10.9551L5.25 10.9551C4.00781 10.9551 3 9.94727 3 8.70508L3 7.20508C3 5.96289 4.00781 4.95508 5.25 4.95508L12.75 4.95508C13.9922 4.95508 15 5.96289 15 7.20508L15 8.70508C15 9.94727 13.9922 10.9551 12.75 10.9551Z"
                                  fill="#3D4BA8"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Combined Grid: Pools + Map -->
            <div
                    id="pools"
                    class="grid gap-6"
                    :class="view === 'list' ? 'grid-cols-1 md:grid-cols-3' : 'grid-cols-1 md:grid-cols-3'"
            >

                <!-- Pools Wrapper -->
                <div
                        x-show="!fullMap"
                        :class="view === 'list' ? 'col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6' : 'col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6'"
                >
                    <template x-for="pool in pools" :key="pool.id">
                        <div class="card-hover overflow-hidden rounded-lg bg-white h-min">
                            <a :href="pool.url" class="relative block w-full aspect-video image-effect">
                                <img :src="pool.image" alt=""
                                     class="absolute inset-0 size-full object-cover object-center">
                            </a>
                            <div class="p-4 flex flex-col gap-1">
                                <h3 class="text-2xl font-bold text-blue-dark">
                                    <a :href="pool.url" x-text="pool.title"></a>
                                </h3>
                                <p x-text="pool.location.name" class="text-blue"></p>
                                <p class="text-blue">
                                    <span x-text="pool.location.post_code !== null ? pool.location.post_code + ', ' : ''"></span>
                                    <span x-text="pool.location.city"></span>
                                </p>
                                <div class="mt-6">
                                    <a :href="pool.url" class="button button--sm button--primary">
                                        <span>EN SAVOIR PLUS</span>
                                        <span class="wave" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Map Column -->
                <div x-show="view === 'map'" x-cloak class="h-full max-h-[80dvh] sticky top-[70px]"
                     :class="fullMap ? 'col-span-full' : 'col-span-full lg:col-span-1'">
                    <button type="button" @click="fullMap = !fullMap"
                            class="button button--sm button--primary absolute top-3 right-3 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/>
                        </svg>
                    </button>
                    <div id="map" class="w-full h-full min-h-[500px] bg-gray-100 rounded-lg">
                    </div>
                    <!-- Pool Popup (Initially hidden) -->
                    <div id="pool-popup"
                         x-show="poolMapPopup"
                         style="display: none;"
                         class="absolute bottom-5 left-5 z-50 w-[320px] rounded-xl shadow-2xl bg-white overflow-hidden text-sm">
                        <div class="relative aspect-video">
                            <img id="popup-image" src="" alt="Pool" class="size-full object-cover object-center inset-0 absolute"/>
                            <button @click="poolMapPopup = false"
                                    class="cursor-pointer absolute top-2 right-2 bg-[#f6531d] text-white rounded-full w-7 h-7 flex items-center justify-center text-lg font-bold shadow-md">
                                ×
                            </button>
                        </div>
                        <div class="p-4">
                            <h3 id="popup-title" class="text-lg font-semibold mb-1"></h3>
                            <p id="popup-size-temp" class="text-gray-700"></p>
                            <p id="popup-address" class="text-gray-600 mt-1 whitespace-pre-line"></p>
                            <a href="" id="popup-more"
                               class="mt-4 button button--sm button--primary">
                                <span>EN SAVOIR PLUS</span>
                                <span class="wave" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
get_footer(); ?>