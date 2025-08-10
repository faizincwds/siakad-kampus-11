        <!-- Small Device Overlay Start -->
		<div
		  @click="sidebarToggle = false"
		  :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
		  class="fixed w-full h-screen z-9 bg-gray-900/50"
		></div>
		<!-- Small Device Overlay End -->

		<!-- ===== Header Start ===== -->
		<header
		  x-data="{menuToggle: false}"
		  class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white lg:border-b dark:border-gray-800 dark:bg-gray-900"
		>
		  <div
		    class="flex grow flex-col items-center justify-between lg:flex-row lg:px-6"
		  >
		    <div
		      class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:justify-normal lg:border-b-0 lg:px-0 lg:py-4 dark:border-gray-800"
		    >
		      <!-- Hamburger Toggle BTN -->
		      <button
		        :class="sidebarToggle ? 'lg:bg-transparent dark:lg:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
		        class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 lg:h-11 lg:w-11 lg:border dark:border-gray-800 dark:text-gray-400"
		        @click.stop="sidebarToggle = !sidebarToggle"
		      >
		        <svg
		          class="hidden fill-current lg:block"
		          width="16"
		          height="12"
		          viewBox="0 0 16 12"
		          fill="none"
		          xmlns="http://www.w3.org/2000/svg"
		        >
		          <path
		            fill-rule="evenodd"
		            clip-rule="evenodd"
		            d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
		            fill=""
		          />
		        </svg>

		        <svg
		          :class="sidebarToggle ? 'hidden' : 'block lg:hidden'"
		          class="fill-current lg:hidden"
		          width="24"
		          height="24"
		          viewBox="0 0 24 24"
		          fill="none"
		          xmlns="http://www.w3.org/2000/svg"
		        >
		          <path
		            fill-rule="evenodd"
		            clip-rule="evenodd"
		            d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
		            fill=""
		          />
		        </svg>

		        <!-- cross icon -->
		        <svg
		          :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
		          class="fill-current"
		          width="24"
		          height="24"
		          viewBox="0 0 24 24"
		          fill="none"
		          xmlns="http://www.w3.org/2000/svg"
		        >
		          <path
		            fill-rule="evenodd"
		            clip-rule="evenodd"
		            d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
		            fill=""
		          />
		        </svg>
		      </button>
		      <!-- Hamburger Toggle BTN -->

		      <a href="/" class="lg:hidden">
		        <img class="dark:hidden" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
		        <img
		          class="hidden dark:block"
		          src="{{ asset('images/logo/logo-dark.svg') }}"
		          alt="Logo"
		        />
		      </a>

		      <!-- Application nav menu button -->
		      <button
		        class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 lg:hidden dark:text-gray-400 dark:hover:bg-gray-800"
		        :class="menuToggle ? 'bg-gray-100 dark:bg-gray-800' : ''"
		        @click.stop="menuToggle = !menuToggle"
		      >
		        <svg
		          class="fill-current"
		          width="24"
		          height="24"
		          viewBox="0 0 24 24"
		          fill="none"
		          xmlns="http://www.w3.org/2000/svg"
		        >
		          <path
		            fill-rule="evenodd"
		            clip-rule="evenodd"
		            d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
		            fill=""
		          />
		        </svg>
		      </button>
		      <!-- Application nav menu button -->

		    </div>

		    <div
		      :class="menuToggle ? 'flex' : 'hidden'"
		      class="shadow-theme-md w-full items-center justify-between gap-4 px-5 py-4 lg:flex lg:justify-end lg:px-0 lg:shadow-none"
		    >
		      <div class="2xsm:gap-3 flex items-center gap-2">

		        <!-- Dark Mode Toggler -->
		        <button class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" @click.prevent="darkMode = !darkMode">

                  <svg class="hidden dark:block w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                  </svg>


                    <svg class="dark:hidden w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 0 1-.5-17.986V3c-.354.966-.5 1.911-.5 3a9 9 0 0 0 9 9c.239 0 .254.018.488 0A9.004 9.004 0 0 1 12 21Z"/>
                    </svg>

		        </button>
		        <!-- Dark Mode Toggler -->

		        <!-- Notification Menu Area -->
		        <div class="relative" x-data="{ dropdownOpen: false, notifying: true }" @click.outside="dropdownOpen = false">
		          <button
		            class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
		            @click.prevent="dropdownOpen = ! dropdownOpen; notifying = false"
		          >
		            <span
		              :class="!notifying ? 'hidden' : 'flex'"
		              class="absolute top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-orange-400"
		            >
		              <span
		                class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"
		              ></span>
		            </span>
                    <svg class="w-6 h-6 text-gray-500 dark:text-white/70" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                    </svg>

		          </button>

		          <!-- Dropdown Start -->
		          <div
		            x-show="dropdownOpen"
		            class="shadow-theme-lg dark:bg-gray-dark absolute -right-[240px] mt-[17px] flex h-[280px] w-[350px] flex-col rounded-2xl border border-gray-200 bg-white p-3 sm:w-[361px] lg:right-0 dark:border-gray-800"
		          >
		            <div
		              class="mb-3 flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800"
		            >
		              <h5
		                class="text-lg font-semibold text-gray-800 dark:text-white/90"
		              >
		                Notification
		              </h5>

		              <button
		                @click="dropdownOpen = false"
		                class="text-gray-500 dark:text-gray-400"
		              >
		                <svg
		                  class="fill-current"
		                  width="24"
		                  height="24"
		                  viewBox="0 0 24 24"
		                  fill="none"
		                  xmlns="http://www.w3.org/2000/svg"
		                >
		                  <path
		                    fill-rule="evenodd"
		                    clip-rule="evenodd"
		                    d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
		                    fill=""
		                  />
		                </svg>
		              </button>
		            </div>

		            <ul class="custom-scrollbar flex h-auto flex-col overflow-y-auto">
		              <li>
		                <a
		                  class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
		                  href="#"
		                >
		                  <span
		                    class="relative z-1 block h-10 w-full max-w-10 rounded-full"
		                  >
		                    <img
		                      src="{{ asset('images/user/user-02.jpg') }}"
		                      alt="User"
		                      class="overflow-hidden rounded-full"
		                    />
		                    <span
		                      class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
		                    ></span>
		                  </span>

		                  <span class="block">
		                    <span
		                      class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
		                    >
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Terry Franci</span
		                      >
		                      requests permission to change
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Project - Nganter App</span
		                      >
		                    </span>

		                    <span
		                      class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
		                    >
		                      <span>Project</span>
		                      <span class="h-1 w-1 rounded-full bg-gray-400"></span>
		                      <span>5 min ago</span>
		                    </span>
		                  </span>
		                </a>
		              </li>

		              <li>
		                <a
		                  class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
		                  href="#"
		                >
		                  <span
		                    class="relative z-1 block h-10 w-full max-w-10 rounded-full"
		                  >
		                    <img
		                      src="{{ asset('images/user/user-03.jpg') }}"
		                      alt="User"
		                      class="overflow-hidden rounded-full"
		                    />
		                    <span
		                      class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
		                    ></span>
		                  </span>

		                  <span class="block">
		                    <span
		                      class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
		                    >
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Alena Franci</span
		                      >
		                      requests permission to change
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Project - Nganter App</span
		                      >
		                    </span>

		                    <span
		                      class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
		                    >
		                      <span>Project</span>
		                      <span class="h-1 w-1 rounded-full bg-gray-400"></span>
		                      <span>8 min ago</span>
		                    </span>
		                  </span>
		                </a>
		              </li>

		              <li>
		                <a
		                  class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
		                  href="#"
		                >
		                  <span
		                    class="relative z-1 block h-10 w-full max-w-10 rounded-full"
		                  >
		                    <img
		                      src="{{ asset('images/user/user-04.jpg') }}"
		                      alt="User"
		                      class="overflow-hidden rounded-full"
		                    />
		                    <span
		                      class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
		                    ></span>
		                  </span>

		                  <span class="block">
		                    <span
		                      class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
		                    >
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Jocelyn Kenter</span
		                      >
		                      requests permission to change
		                      <span class="font-medium text-gray-800 dark:text-white/90"
		                        >Project - Nganter App</span
		                      >
		                    </span>

		                    <span
		                      class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
		                    >
		                      <span>Project</span>
		                      <span class="h-1 w-1 rounded-full bg-gray-400"></span>
		                      <span>15 min ago</span>
		                    </span>
		                  </span>
		                </a>
		              </li>

		            </ul>

		            <a
		              href="#"
		              class="text-theme-sm shadow-theme-xs mt-1 flex justify-center rounded-lg border border-gray-300 bg-white p-3 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
		            >
		              View All Notification
		            </a>
		          </div>
		          <!-- Dropdown End -->
		        </div>
		        <!-- Notification Menu Area -->
		        </div>

		      <!-- User Area -->
                <div class="relative" x-data="{ dropdownOpen: false }"  @click.outside="dropdownOpen = false" >
		        <a
		          class="flex items-center text-gray-700 dark:text-gray-400"
		          href="#"
		          @click.prevent="dropdownOpen = ! dropdownOpen"
		        >
		            {{-- <img src="{{ asset('images/user/owner.jpg') }}" alt="User" /> --}}
                    <svg class="mr-3 overflow-hidden w-11 h-11 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                    </svg>


		          <span class="text-theme-sm mr-1 block font-medium">  {{ Auth::user()->name }}
                    <span class="text-theme-xs block text-gray-500 dark:text-gray-400">
		              {{ Auth::user()->email }}
		            </span>
                  </span>

		          <svg
		            :class="dropdownOpen && 'rotate-180'"
		            class="stroke-gray-500 dark:stroke-gray-400"
		            width="18"
		            height="20"
		            viewBox="0 0 18 20"
		            fill="none"
		            xmlns="http://www.w3.org/2000/svg"
		          >
		            <path
		              d="M4.3125 8.65625L9 13.3437L13.6875 8.65625"
		              stroke=""
		              stroke-width="1.5"
		              stroke-linecap="round"
		              stroke-linejoin="round"
		            />
		          </svg>
		        </a>

		        <!-- Dropdown Start -->
		        <div
		          x-show="dropdownOpen"
		          class="shadow-theme-lg dark:bg-gray-dark absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 dark:border-gray-800"
		        >

		          <ul
		            class="flex flex-col gap-1 border-b border-gray-200 pb-3 dark:border-gray-800"
		          >
		            <li>
		              <a
		                href="profile.html"
		                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
		              >
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

		                Edit profile
		              </a>
		            </li>
		            <li>
		              <a
		                href="messages.html"
		                class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
		              >
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                           <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

		                Account settings
		              </a>
		            </li>

		          </ul>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
		          <button
		            class="group w-full text-theme-sm mt-3 flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" onclick="submit();"
		          >
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                    </svg>


		            Sign out
		          </button>
                </form>
		        </div>
		        <!-- Dropdown End -->
		      </div>
		      <!-- User Area -->
		    </div>
		  </div>
		</header>
		<!-- ===== Header End ===== -->
