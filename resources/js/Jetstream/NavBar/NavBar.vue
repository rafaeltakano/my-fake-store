<template>
  <div class="bg-white">
    <!-- Mobile menu -->
    <slot name="nav-mobile"> </slot>

    <header class="relative bg-white">
      <nav aria-label="Top" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
          <div class="h-16 flex items-center">
            <!-- Mobile Sandwich -->
            <slot name="nav-mobile-sandwich"></slot>

            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0">
              <a href="/">
                <span class="sr-only">Workflow</span>
                <img
                  class="h-8 w-auto"
                  src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600"
                  alt=""
                />
              </a>
            </div>

            <!-- Flyout menus -->
            <slot name="nav-popover"></slot>

            <div class="ml-auto flex items-center">
              <!-- Search -->
              <div class="flex lg:ml-6">
                <slot name="nav-search-input"></slot>
              </div>

              <!-- Cart -->
              <div class="ml-4 flow-root lg:ml-6">
                <a href="#" class="group -m-2 p-2 flex items-center">
                  <!-- Shopping Bag -->
                  <slot name="nav-shopping-bag"></slot>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
  </div>
</template>

