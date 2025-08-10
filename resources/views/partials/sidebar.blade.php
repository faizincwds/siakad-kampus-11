	<!-- ===== Sidebar Start ===== -->
	<aside
	  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
	  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[230px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
	>
	  <!-- SIDEBAR HEADER -->
			  <div
			    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
			    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
			  >
			    <a href="{{ route('dashboard') }}">
			      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
			        <img class="dark:hidden" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
			        <img
			          class="hidden dark:block"
			          src="{{ asset('images/logo/logo-dark.svg') }}"
			          alt="Logo"
			        />
			      </span>

			      <img
			        class="logo-icon"
			        :class="sidebarToggle ? 'lg:block' : 'hidden'"
			        src="{{ asset('images/logo/logo-icon.svg') }}"
			        alt="Logo"
			      />
			    </a>
			  </div>
	  <!-- SIDEBAR HEADER -->

	  <div
	    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
	  >

            <button
             class="mb-4 p-2 text-center rounded-full bg-yellow-50 dark:bg-gray-200 px-2 py-0.5 text-theme-xs font-medium text-warning-500 dark:text-gray-700"
             :class="sidebarToggle ? 'lg:hidden' : ''">
	            Semester: [2024/2025 Genap]
	        </button>

	    <!-- Sidebar Menu -->
	    <nav x-data="{selected: $persist('Dashboard')}">

	      <!-- Menu Group -->
	      <div>
	        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
	          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
	            MAIN
	          </span>

	          <svg
	            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
	            class="mx-auto fill-current menu-group-icon"
	            width="24"
	            height="24"
	            viewBox="0 0 24 24"
	            fill="none"
	            xmlns="http://www.w3.org/2000/svg"
	          >
	            <path
	              fill-rule="evenodd"
	              clip-rule="evenodd"
	              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
	              fill=""
	            />
	          </svg>
	        </h3>

	        <ul class="flex flex-col gap-1 mb-6">


	          <!-- Menu Item Dashboard -->
	          <li>
	            <a
	              href="{{ route('dashboard') }}"
	              @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
	              class="menu-item group"
	              :class=" (selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-active' : 'menu-item-inactive'"
	            >

                <svg
                :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 3a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm14 18a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4ZM5 11a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H5Zm14 2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4Z"/>
                </svg>

	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >

	                Dashboard
	              </span>
	            </a>
	          </li>
	          <!-- End Menu Item Dashboard -->
	          <!-- Menu Item Lembaga -->
	          <li>
	            <a
	              href="#"
	              @click="selected = (selected === 'Lembaga' ? '':'Lembaga')"
	              class="menu-item group"
	              :class=" (selected === 'Lembaga') && (page === 'lembaga') ? 'menu-item-active' : 'menu-item-inactive'"
	            >
                <svg
                :class="(selected === 'Lembaga') && (page === 'lembaga') ?  'menu-item-icon-active'  :'menu-item-icon-inactive'"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M10.915 2.345a2 2 0 0 1 2.17 0l7 4.52A2 2 0 0 1 21 8.544V9.5a1.5 1.5 0 0 1-1.5 1.5H19v6h1a1 1 0 1 1 0 2H4a1 1 0 1 1 0-2h1v-6h-.5A1.5 1.5 0 0 1 3 9.5v-.955a2 2 0 0 1 .915-1.68l7-4.52ZM17 17v-6h-2v6h2Zm-6-6h2v6h-2v-6Zm-2 6v-6H7v6h2Z" clip-rule="evenodd"/>
                <path d="M2 21a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1Z"/>
                </svg>



	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >
	                Profil Lembaga
	              </span>
	            </a>
	          </li>
	          <!-- End Menu Item Lembaga -->
              <!-- Menu Item Dosen -->
	          <li>
	            <a
	              href="{{ route('admin.dosen.index') }}"
	              @click="selected = (selected === 'Dosen' ? '':'Dosen')"
	              class="menu-item group"
	              :class=" (selected === 'Dosen') && (page === 'dosen') ? 'menu-item-active' : 'menu-item-inactive'"
	            >

                <svg
                  :class="(selected === 'Dosen') && (page === 'dosen') ?  'menu-item-icon-active'  :'menu-item-icon-inactive'"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                </svg>


	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >
	                Dosen
	              </span>
	            </a>
	          </li>
	          <!-- End Menu Item Dosen -->
	          <!-- Menu Item Mahasiswa -->
	          <li>
	            <a
	              href="#"
	              @click.prevent="selected = (selected === 'MahasiswaData' ? '':'MahasiswaData')"
	              class="menu-item group"
	              :class=" (selected === 'MahasiswaData') || (page === 'mahasiswaData') ? 'menu-item-active' : 'menu-item-inactive'"
	            >
	              <svg
                :class="(selected === 'MahasiswaData') || (page === 'mahasiswa' || page === 'users' ) ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.4472 4.10557c-.2815-.14076-.6129-.14076-.8944 0L2.76981 8.49706l9.21949 4.39024L21 8.38195l-8.5528-4.27638Z"/>
                <path d="M5 17.2222v-5.448l6.5701 3.1286c.278.1325.6016.1293.8771-.0084L19 11.618v5.6042c0 .2857-.1229.5583-.3364.7481l-.0025.0022-.0041.0036-.0103.009-.0119.0101-.0181.0152c-.024.02-.0562.0462-.0965.0776-.0807.0627-.1942.1465-.3405.2441-.2926.195-.7171.4455-1.2736.6928C15.7905 19.5208 14.1527 20 12 20c-2.15265 0-3.79045-.4792-4.90614-.9751-.5565-.2473-.98098-.4978-1.27356-.6928-.14631-.0976-.2598-.1814-.34049-.2441-.04036-.0314-.07254-.0576-.09656-.0776-.01201-.01-.02198-.0185-.02991-.0253l-.01038-.009-.00404-.0036-.00174-.0015-.0008-.0007s-.00004 0 .00978-.0112l-.00009-.0012-.01043.0117C5.12215 17.7799 5 17.5079 5 17.2222Zm-3-6.8765 2 .9523V17c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6543Z"/>
                </svg>

	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >
	                Mahasiswa
	              </span>

	              <svg
	                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
	                :class="[(selected === 'MahasiswaData') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
	                width="20"
	                height="20"
	                viewBox="0 0 20 20"
	                fill="none"
	                xmlns="http://www.w3.org/2000/svg"
	              >
	                <path
	                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
	                  stroke=""
	                  stroke-width="1.5"
	                  stroke-linecap="round"
	                  stroke-linejoin="round"
	                />
	              </svg>
	            </a>

	            <!-- Dropdown Menu Start -->
	            <div
	              class="overflow-hidden transform translate"
	              :class="(selected === 'MahasiswaData') ? 'block' :'hidden'"
	            >
	              <ul
	                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
	                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
	              >
                    <li>
	                  <a
	                    href="{{ route('admin.mahasiswa.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'mahasiswa' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Data Mahasiswa
	                  </a>
	                </li>
	              </ul>
	            </div>
	            <!-- Dropdown Menu End -->
	          </li>
	          <!-- End Menu Item Mahasiswa -->
	        </ul>
	      </div>

          <!-- Group Menu Perkuliahan -->
	      <div>
	        <h3 class="mb-2 text-xs uppercase leading-[20px] text-gray-400">
	          <span
	            class="menu-group-title"
	            :class="sidebarToggle ? 'lg:hidden' : ''"
	          >
	            Perkuliahan
	          </span>

	          <svg
	            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
	            class="mx-auto fill-current menu-group-icon"
	            width="24"
	            height="24"
	            viewBox="0 0 24 24"
	            fill="none"
	            xmlns="http://www.w3.org/2000/svg"
	          >
	            <path
	              fill-rule="evenodd"
	              clip-rule="evenodd"
	              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
	              fill=""
	            />
	          </svg>

	        </h3>

	        <ul class="flex flex-col gap-1 mb-6">
	          <!-- Menu Item Perkuliahan -->
	          <li>
	            <a
	              href="#"
	              @click.prevent="selected = (selected === 'Perkuliahan' ? '':'Perkuliahan')"
	              class="menu-item group"
	              :class="(selected === 'Perkuliahan') || ( page === 'kelas' || page === 'krs' || page === 'khs') ? 'menu-item-active' : 'menu-item-inactive'"
	            >
                <svg
                :class="(selected === 'Perkuliahan') || ( page === 'kelas' || page === 'krs' || page === 'khs') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                class="text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z"/>
                </svg>


	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >
	                Perkuliahan
	              </span>

	              <svg
	                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
	                :class="[(selected === 'Perkuliahan') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
	                width="20"
	                height="20"
	                viewBox="0 0 20 20"
	                fill="none"
	                xmlns="http://www.w3.org/2000/svg"
	              >
	                <path
	                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
	                  stroke=""
	                  stroke-width="1.5"
	                  stroke-linecap="round"
	                  stroke-linejoin="round"
	                />
	              </svg>
	            </a>

	            <!-- Dropdown Menu Start -->
	            <div
	              class="overflow-hidden transform translate"
	              :class="(selected === 'Perkuliahan') ? 'block' :'hidden'"
	            >
	              <ul
	                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
	                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
	              >

	                <li>
	                  <a
	                    href="bar-chart.html"
	                    class="menu-dropdown-item group"
	                    :class="page === 'kelas' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Kelas Perkuliahan
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="bar-chart.html"
	                    class="menu-dropdown-item group"
	                    :class="page === 'krs' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    KRS Mahasiswa
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="bar-chart.html"
	                    class="menu-dropdown-item group"
	                    :class="page === 'khs' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Nilai Perkuliahan
	                  </a>
	                </li>
	              </ul>
	            </div>
	            <!-- Dropdown Menu End -->
	          </li>
	          <!-- Menu Item Perkuliahan -->
	        </ul>
	      </div>
          <!-- End Group Menu Perkuliahan -->

          <!-- Grup Menu Pengaturan -->
          <div>
	        <h3 class="mb-2 text-xs uppercase leading-[20px] text-gray-400">
	          <span
	            class="menu-group-title"
	            :class="sidebarToggle ? 'lg:hidden' : ''"
	          >
	            Pengaturan
	          </span>

	          <svg
	            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
	            class="mx-auto fill-current menu-group-icon"
	            width="24"
	            height="24"
	            viewBox="0 0 24 24"
	            fill="none"
	            xmlns="http://www.w3.org/2000/svg"
	          >
	            <path
	              fill-rule="evenodd"
	              clip-rule="evenodd"
	              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
	              fill=""
	            />
	          </svg>
	        </h3>

	        <ul class="flex flex-col gap-1 mb-6">
                <!-- Menu Item Master Data -->
	          <li>
	            <a
	              href="#"
	              @click.prevent="selected = (selected === 'MasterData' ? '':'MasterData')"
	              class="menu-item group"
	              :class=" (selected === 'MasterData') || (page === 'masterData') ? 'menu-item-active' : 'menu-item-inactive'"
	            >
                <svg
                :class="(selected === 'MasterData') || ( page === 'kurikulum' || page === 'ruangan' || page === 'mataKuliah' || page === 'programStudi' || page === 'permissions' || page === 'semesters' || page === 'skalaNilai' || page === 'users' ) ? 'menu-item-icon-active'  :'menu-item-icon-inactive'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5 5a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a2 2 0 0 0-2-2H5Zm9 2a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H14Zm3 0a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17ZM3 17v-3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm11-2a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H14Zm3 0a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                </svg>


	              <span
	                class="menu-item-text"
	                :class="sidebarToggle ? 'lg:hidden' : ''"
	              >
	                Master Data
	              </span>

	              <svg
	                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
	                :class="[(selected === 'MasterData') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
	                width="20"
	                height="20"
	                viewBox="0 0 20 20"
	                fill="none"
	                xmlns="http://www.w3.org/2000/svg"
	              >
	                <path
	                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
	                  stroke=""
	                  stroke-width="1.5"
	                  stroke-linecap="round"
	                  stroke-linejoin="round"
	                />
	              </svg>
	            </a>

	            <!-- Dropdown Menu Start -->
	            <div
	              class="overflow-hidden transform translate"
	              :class="(selected === 'MasterData') ? 'block' :'hidden'"
	            >
	              <ul
	                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
	                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
	              >
                  <li>
	                  <a
	                    href="{{ route('admin.semesters.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'semesters' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Periode
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="{{ route('admin.rooms.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'ruangan' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Ruangan Kelas
	                  </a>
	                </li>
	                <li>
	                  <a
	                    href="{{ route('admin.kurikulum.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'kurikulum' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Kurikulum
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="{{ route('admin.mata-kuliah.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'mataKuliah' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Mata Kuliah
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="{{ route('admin.program-studi.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'programStudi' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Program Studi
	                  </a>
	                </li>

                    <li>
	                  <a
	                    href="{{ route('admin.semesters.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'skalaNilai' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Skala Nilai
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="{{ route('admin.permissions.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'permissions' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Permissions
	                  </a>
	                </li>
                    <li>
	                  <a
	                    href="{{ route('admin.users.index') }}"
	                    class="menu-dropdown-item group"
	                    :class="page === 'users' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
	                  >
	                    Data User
	                  </a>
	                </li>
	              </ul>
	            </div>
	            <!-- Dropdown Menu End -->
	          </li>
	            <!-- Menu Item Master Data -->

	        </ul>
	      </div>
          <!-- End Grup Menu Pengaturan -->





	    </nav>
	    <!-- Sidebar Menu -->

	  </div>
	</aside>

      <!-- ===== Sidebar End ===== -->
