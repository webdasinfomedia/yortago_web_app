<style>
@media only screen and (min-width: 800px) and (max-width: 1300px) {
    /* Default FULL sidebar - NOT mini */
    .deznav {
        width: 17rem !important;
        display: block !important;
        position: fixed;
        height: 100vh;
        overflow: hidden;
        left: 0;
        top: 0;
        padding-top: 91px;
        z-index: 3;
        background-color: #1e1e1e;
        transition: all .3s ease;
    }

    .nav-header {
        width: 17rem !important;
        transition: all .3s ease;
    }

    .content-body {
        margin-left: 17rem !important;
        transition: all .3s ease;
    }

    /* Show full logo and text by default */
    .nav-header .brand-title,
    .nav-header  {
        display: inline-block !important;
    }

    .nav-header .logo-abbr {
        display: none !important;
    }

    .deznav .metismenu li a .nav-text {
        display: inline-block !important;
    }

    /* Show hamburger toggle button */
    .hamburger {
        display: inline-block !important;
        cursor: pointer;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .nav-control {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        z-index: 9999 !important;
    }

    /* Mini mode - ONLY when menu-toggle class is added */
    body.menu-toggle .deznav,
    [data-sidebar-style="mini"] .deznav {
        width: 5rem !important;
        display: block !important;
    }
  
    body.menu-toggle .nav-header,
    [data-sidebar-style="mini"] .nav-header {
        width: 5rem !important;
    }
     [data-sidebar-style="mini"] .header {
        padding-left: 15rem !important;
    }

    body.menu-toggle .content-body,
    [data-sidebar-style="mini"] .content-body {
        margin-left: 5rem !important;
    }

    /* Hide text in mini mode */
    body.menu-toggle .deznav .metismenu li a .nav-text,
    [data-sidebar-style="mini"] .deznav .metismenu li a .nav-text {
        display: none !important;
    }

    body.menu-toggle .nav-header .brand-title,
    body.menu-toggle .nav-header .logo-compact,
    [data-sidebar-style="mini"] .nav-header .brand-title,
    [data-sidebar-style="mini"] .nav-header .logo-compact {
        display: none !important;
    }

    body.menu-toggle .nav-header .logo-abbr,
    [data-sidebar-style="mini"] .nav-header .logo-abbr {
        display: inline-block !important;
    }

    /* Center icons in mini mode */
    body.menu-toggle .deznav .metismenu > li > a,
    [data-sidebar-style="mini"] .deznav .metismenu > li > a {
        text-align: center;
        justify-content: center;
        padding: 0.813rem 0 !important;
    }

    body.menu-toggle .deznav .metismenu > li > a i,
    [data-sidebar-style="mini"] .deznav .metismenu > li > a i {
        margin-right: 0 !important;
    }

    /* Hide submenu arrows in mini mode */
    body.menu-toggle .deznav .metismenu .has-arrow::after,
    [data-sidebar-style="mini"] .deznav .metismenu .has-arrow::after {
        display: none !important;
    }

    /* Hide submenu in mini mode */
    body.menu-toggle .deznav .metismenu ul,
    [data-sidebar-style="mini"] .deznav .metismenu ul {
        display: none !important;
    }

    /* Keep hamburger visible even in mini mode */
    body.menu-toggle .hamburger,
    [data-sidebar-style="mini"] .hamburger {
        display: inline-block !important;
    }
}
</style>
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

            </li>
            <li class="d-none"><a class="ai-icon" href="{{ route('admin.streaming.list') }}" aria-expanded="false">
                    <i class="la la-tasks"></i>
                    <span class="nav-text">Stream Plan</span>
                </a>
            </li>
            <li class="d-none"><a class="ai-icon" href="{{ route('admin.live.streaming.list') }}" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Live Stream</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.new.exercise.manage') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Exercise Program</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.exercise.program.list') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Old Exercise Program</span>
                </a>
            </li>
            <!-- new module - excersice management -->
            <li><a class="ai-icon" href="{{ route('admin.new.exercise.unified_exercise_management') }}" aria-expanded="false">
                    <i class="la la-running"></i>
                    <span class="nav-text">Exercise Management</span>
                </a>
            </li>
            <!-- <li><a class="ai-icon" href="{{ route('admin.new.exercise.categories') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Categories</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.new.exercise.bodyparts') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Body parts</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.new.exercise.exercise_style') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Exercise Style</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('admin.new.exercise.exercise_list') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Exercise List</span>
                </a>
            </li> -->
            <li><a class="ai-icon" href="{{ route('admin.cms.education_hub_page_setting') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Education Hub</span>
                </a>
            </li>
            <li class="d-none"><a class="ai-icon" href="{{ route('admin.exercise.program.list') }}" aria-expanded="false">
                    <i class="la la-dumbbell"></i>
                    <span class="nav-text">Exercise Program</span>
                </a>
            </li>

            <li class="d-none"><a class="ai-icon" href="{{ route('admin.nutrition.program.list') }}" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Nutrition Program</span>
                </a>
            </li>
            <!-- <li><a class="ai-icon" href="{{ route('admin.online.training.plan.list') }}" aria-expanded="false">
                    <i class="la la-dollar"></i>
                    <span class="nav-text">Online Training Plan</span>
                </a>
            </li> -->


            <li><a class="ai-icon" href="{{ route('admin.testimonial.list') }}" aria-expanded="false">
                    <i class="la la-quote-left"></i>
                    <span class="nav-text">Testimonial</span>
                </a>
            <li><a class="ai-icon" href="{{ route('admin.users.list') }}" aria-expanded="false">
                    <i class="la la-users"></i>
                    <span class="nav-text">End User/Athlete</span>
                </a>

            </li>
            <li><a class="ai-icon" href="{{ route('admin.live-stream.users.list') }}" aria-expanded="false">
                    <i class="la la-users"></i>
                    <span class="nav-text"> Users</span>
                </a>

            </li>
            <li><a class="ai-icon" href="{{ route('admin.newsletter.list') }}" aria-expanded="false">
                    <i class="la la-envelope"></i>
                    <span class="nav-text">NewsLetter</span>
                </a>

            </li>
            <li><a class="ai-icon" href="{{ route('admin.in.person.list') }}" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">In Person Contact</span>
                </a>

            </li>

            <!-- <li><a class="ai-icon" href="{{ route('admin.metrics.list') }}" aria-expanded="false">
                    <i class="la la-user"></i>
                    <span class="nav-text">Metrics</span>
                </a>

            </li> -->

            <li class="has-arrow ai-icon {{ request()->is('admin/cms*') && !request()->routeIs('admin.cms.education_hub_page_setting')  && !request()->routeIs('admin.cms.create_education_hub') ? 'mm-active' : '' }}">
                <a href="javascript:void(0)"
                    class="cms-toggle"
                    aria-expanded="{{ request()->is('admin/cms*') ? 'true' : 'false' }}">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">CMS</span>
                </a>
                <ul class="mm-collapse {{ request()->is('admin/cms*') && !request()->routeIs('admin.cms.education_hub_page_setting')  && !request()->routeIs('admin.cms.create_education_hub') ? 'mm-show' : '' }}">
                    <li><a href="{{ route('admin.cms.home_page_setting') }}" class="{{ request()->routeIs('admin.cms.home_page_setting') ? 'active' : '' }}">Home Page Setting</a></li>
                    <li><a href="{{ route('admin.cms.in_person_page_setting') }}" class="{{ request()->routeIs('admin.cms.in_person_page_setting') ? 'active' : '' }}">In-Person Page Setting</a></li>
                    <li><a href="{{ route('admin.cms.online_page_setting') }}" class="{{ request()->routeIs('admin.cms.online_page_setting') ? 'active' : '' }}">Online Page Setting</a></li>
                    <li><a href="{{ route('admin.cms.blogs_page_setting') }}" class="{{ request()->routeIs('admin.cms.blogs_page_setting') ? 'active' : '' }}">Blogs Page Setting</a></li>
                    <li><a href="{{ route('admin.cms.faqs') }}" class="{{ request()->routeIs('admin.cms.faqs') ? 'active' : '' }}">Faqs Setting</a></li>
                    <li><a href="{{ route('admin.cms.seo') }}" class="{{ request()->routeIs('admin.cms.seo') ? 'active' : '' }}">SEO</a></li>
                    <li><a href="{{ route('admin.cms.about') }}" class="{{ request()->routeIs('admin.cms.about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('admin.cms.term') }}" class="{{ request()->routeIs('admin.cms.term') ? 'active' : '' }}">Term Condition</a></li>
                    <li><a href="{{ route('admin.cms.privacy') }}" class="{{ request()->routeIs('admin.cms.privacy') ? 'active' : '' }}">Privacy Policy</a></li>
                    <li><a href="{{ route('admin.cms.slider') }}" class="{{ request()->routeIs('admin.cms.slider') ? 'active' : '' }}">Home Slider</a></li>
                    <li><a href="{{ route('admin.cms.site.config') }}" class="{{ request()->routeIs('admin.cms.site.config') ? 'active' : '' }}">Site Configuration</a></li>
                    <li><a href="{{ route('admin.cms.age.list') }}" class="{{ request()->routeIs('admin.cms.age.list') ? 'active' : '' }}">Focus</a></li>
                    <li><a href="{{ route('admin.cms.equipment.list') }}" class="{{ request()->routeIs('admin.cms.equipment.list') ? 'active' : '' }}">Equipment</a></li>
                    <li><a href="{{ route('admin.cms.experience.level.list') }}" class="{{ request()->routeIs('admin.cms.experience.level.list') ? 'active' : '' }}">Experience Level</a></li>
                </ul>
            </li>



        </ul>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.cms-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                let parent = this.closest('li');
                parent.classList.toggle('mm-active');
                parent.querySelector('ul').classList.toggle('mm-show');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const body = document.body;
    const deznav = document.querySelector('.deznav');
    const navHeader = document.querySelector('.nav-header');
    
    // Initialize for 800-1300px screens - START WITH FULL SIDEBAR
    function initializeForScreenSize() {
        const screenWidth = window.innerWidth;
        
        // Only apply logic for 800-1300px screens
        if (screenWidth >= 800 && screenWidth <= 1300) {
            // Start with FULL sidebar (not mini)
            body.classList.remove('menu-toggle');
            body.removeAttribute('data-sidebar-style');
        }
    }
    
    // Toggle function - Only for 800-1300px screens
    function toggleSidebar(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        const screenWidth = window.innerWidth;
        
        // Only toggle on 800-1300px screens
        if (screenWidth >= 800 && screenWidth <= 1300) {
            if (body.classList.contains('menu-toggle')) {
                // Expand to full sidebar
                body.classList.remove('menu-toggle');
                body.removeAttribute('data-sidebar-style');
            } else {
                // Collapse to mini sidebar
                body.classList.add('menu-toggle');
                body.setAttribute('data-sidebar-style', 'mini');
            }
        }
    }
    
    // Hamburger click event
    if (hamburger) {
        hamburger.addEventListener('click', toggleSidebar);
    }
    
    // Window resize handler
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const screenWidth = window.innerWidth;
            
            // If resizing back into 800-1300px range, reset to full sidebar
            if (screenWidth >= 800 && screenWidth <= 1300) {
                body.classList.remove('menu-toggle');
                body.removeAttribute('data-sidebar-style');
            }
        }, 250);
    });
    
    // CMS submenu toggle - Don't toggle in mini mode on 800-1300px
    const cmsToggle = document.querySelector('.cms-toggle');
    if (cmsToggle) {
        cmsToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const screenWidth = window.innerWidth;
            const parent = this.closest('li');
            const submenu = parent.querySelector('ul');
            
            // On 800-1300px screens, prevent submenu toggle in mini mode
            if (screenWidth >= 800 && screenWidth <= 1300) {
                const isMinified = body.classList.contains('menu-toggle');
                if (isMinified) {
                    return; // Don't open submenu in mini mode
                }
            }
            
            parent.classList.toggle('mm-active');
            if (submenu) {
                submenu.classList.toggle('mm-show');
                
                // Scroll to submenu if opened
                if (submenu.classList.contains('mm-show')) {
                    setTimeout(() => {
                        const deznavScroll = document.querySelector('.deznav-scroll');
                        if (deznavScroll) {
                            deznavScroll.scrollTo({
                                top: parent.offsetTop - 100,
                                behavior: 'smooth'
                            });
                        }
                    }, 100);
                }
            }
        });
    }
    
    // Initialize on page load
    initializeForScreenSize();
});
   
</script>