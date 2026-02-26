<?php

declare(strict_types=1);

extract($args);

if (empty($faq_items)) {
    return;
} ?>

<div x-data="{active: null}" class="container grid grid-cols-1 md:grid-cols-2 gap-x-20 gap-y-5">
    <?php
    $faqItemCount = 1;
    foreach ($faq_items as $faqItem) : ?>
        <div x-disclosure x-data="{
            id: <?php
        echo esc_attr($faqItemCount); ?>,
            get expanded() {
                return this.active === this.id
            },
            set expanded(id) {
                this.active = id ? this.id : null
            },
        }" x-model="expanded">
            <button x-disclosure:button type="button" :class="$disclosure.isOpen ? 'rounded-t-2xl' : 'rounded-2xl'" class="flex items-center justify-between w-full bg-white p-5 cursor-pointer">
                <span class="text-lg font-bold text-blue-dark text-left"><?php
                    echo wp_kses_post($faqItem['question']); ?></span>

                <span x-show="$disclosure.isOpen" x-cloak class="size-[21px]">
                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" class="size-[21px]">
                    <path d="M10.5 19a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17Z" fill="#fff"/>
                    <path d="M18.5 10.5a8 8 0 1 0-16 0 8 8 0 0 0 16 0Zm1 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                          fill="#D4DDFA"/>
                    <path d="M13.912 8.74c-1.571 0-2.88-1.086-3.202-2.537-.105-.006-.207-.016-.312-.016-2.615 0-4.735 2.087-4.735 4.662 0 2.575 2.12 4.662 4.735 4.662s4.735-2.087 4.735-4.662c0-.785-.2-1.525-.548-2.178-.216.046-.44.068-.67.068h-.002Z"
                          fill="#D4DDFA"/>
                    <path d="M.646.646a.5.5 0 0 1 .63-.064l.078.064 19 19 .064.078a.5.5 0 0 1-.693.694l-.079-.065-19-19-.064-.078A.5.5 0 0 1 .646.646Z"
                          fill="#D4DDFA"/>
                </svg>
                </span>

                <span x-show="!$disclosure.isOpen" x-cloak class="size-[21px]">
                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="size-[18px]">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Z" fill="#fff"/>
                    <path d="M10.925 6.327A2.809 2.809 0 0 1 8.18 4.119c-.09-.006-.177-.014-.267-.014a4.058 4.058 0 1 0 3.589 2.162c-.186.04-.377.06-.574.06h-.003Z"
                          fill="#8F9CE9"/>
                </svg>
                </span>
            </button>
            <div x-disclosure:panel x-collapse.duration.200ms class="border-t border-[#D4D9FA] bg-white p-5 rounded-b-2xl">
                <p class="text-lg text-blue"><?php
                    echo wp_kses_post($faqItem['answer']); ?></p>
            </div>
        </div>
        <?php
        $faqItemCount++; endforeach; ?>
</div>

