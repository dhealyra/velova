<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo me-1">
          <span class="text-primary">
            <svg width="70" height="70" viewBox="0 0 250 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Shadow -->
                <path d="M20 25 L125 195 L230 20"
                      fill="none"
                      stroke="rgba(0, 0, 0, 0.1)"
                      stroke-width="60"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>

                <!-- Gradient definition -->
                <defs>
                  <linearGradient id="vGradient" x1="125" y1="0" x2="125" y2="200" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#7367F0" />  <!-- Ungu kebiruan Materio -->
                    <stop offset="1" stop-color="#A9A7F1" /> <!-- Ungu pastel -->
                  </linearGradient>
                </defs>

                <!-- Main Huruf V -->
                <path d="M20 20 L125 190 L230 20"
                      fill="none"
                      stroke="url(#vGradient)"
                      stroke-width="50"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
          </span>
        </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-2">Velova</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('kendaraan.index') }}" class="menu-link">Kendaraan</a>
        </li>
{{--
      <!-- Dashboards -->
      <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">

          <div data-i18n="Dashboards">Dashboards</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/dashboards-crm.html"
              target="_blank"
              class="menu-link">
              <div data-i18n="CRM">CRM</div>
              <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
            </a>
          </li>
          <li class="menu-item active">
            <a href="index.html" class="menu-link">
              <div data-i18n="Analytics">Analytics</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-ecommerce-dashboard.html"
              target="_blank"
              class="menu-link">
              <div data-i18n="eCommerce">eCommerce</div>
              <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-logistics-dashboard.html"
              target="_blank"
              class="menu-link">
              <div data-i18n="Logistics">Logistics</div>
              <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-academy-dashboard.html"
              target="_blank"
              class="menu-link">
              <div data-i18n="Academy">Academy</div>
              <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Layouts -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-layout-2-line"></i>
          <div data-i18n="Layouts">Layouts</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="layouts-without-menu.html" class="menu-link">
              <div data-i18n="Without menu">Without menu</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-without-navbar.html" class="menu-link">
              <div data-i18n="Without navbar">Without navbar</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-container.html" class="menu-link">
              <div data-i18n="Container">Container</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-fluid.html" class="menu-link">
              <div data-i18n="Fluid">Fluid</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-blank.html" class="menu-link">
              <div data-i18n="Blank">Blank</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Front Pages -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-file-copy-line"></i>
          <div data-i18n="Front Pages">Front Pages</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/front-pages/landing-page.html"
              class="menu-link"
              target="_blank">
              <div data-i18n="Landing">Landing</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/front-pages/pricing-page.html"
              class="menu-link"
              target="_blank">
              <div data-i18n="Pricing">Pricing</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/front-pages/payment-page.html"
              class="menu-link"
              target="_blank">
              <div data-i18n="Payment">Payment</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/front-pages/checkout-page.html"
              class="menu-link"
              target="_blank">
              <div data-i18n="Checkout">Checkout</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/front-pages/help-center-landing.html"
              class="menu-link"
              target="_blank">
              <div data-i18n="Help Center">Help Center</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Apps & Pages -->
      <li class="menu-header mt-7">
        <span class="menu-header-text">Apps &amp; Pages</span>
      </li>
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-email.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-mail-open-line"></i>
          <div data-i18n="Email">Email</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-chat.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-wechat-line"></i>
          <div data-i18n="Chat">Chat</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-calendar.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-calendar-line"></i>
          <div data-i18n="Calendar">Calendar</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/app-kanban.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-drag-drop-line"></i>
          <div data-i18n="Kanban">Kanban</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <!-- Pages -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-layout-left-line"></i>
          <div data-i18n="Account Settings">Account Settings</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="pages-account-settings-account.html" class="menu-link">
              <div data-i18n="Account">Account</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-account-settings-notifications.html" class="menu-link">
              <div data-i18n="Notifications">Notifications</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-account-settings-connections.html" class="menu-link">
              <div data-i18n="Connections">Connections</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-shield-keyhole-line"></i>
          <div data-i18n="Authentications">Authentications</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Login</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-register-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Register</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Forgot Password</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-box-3-line"></i>
          <div data-i18n="Misc">Misc</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="pages-misc-error.html" class="menu-link" target="_blank">
              <div data-i18n="Error">Error</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link" target="_blank">
              <div data-i18n="Under Maintenance">Under Maintenance</div>
            </a>
          </li>
        </ul>
      </li>
      <!-- Components -->
      <li class="menu-header mt-7"><span class="menu-header-text">Components</span></li>
      <!-- Cards -->
      <li class="menu-item">
        <a href="cards-basic.html" class="menu-link">
          <i class="menu-icon icon-base ri ri-bank-card-2-line"></i>
          <div data-i18n="Basic">Cards</div>
        </a>
      </li>
      <!-- User interface -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-toggle-line"></i>
          <div data-i18n="User interface">User interface</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="ui-accordion.html" class="menu-link">
              <div data-i18n="Accordion">Accordion</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-alerts.html" class="menu-link">
              <div data-i18n="Alerts">Alerts</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-badges.html" class="menu-link">
              <div data-i18n="Badges">Badges</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-buttons.html" class="menu-link">
              <div data-i18n="Buttons">Buttons</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-carousel.html" class="menu-link">
              <div data-i18n="Carousel">Carousel</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-collapse.html" class="menu-link">
              <div data-i18n="Collapse">Collapse</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-dropdowns.html" class="menu-link">
              <div data-i18n="Dropdowns">Dropdowns</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-footer.html" class="menu-link">
              <div data-i18n="Footer">Footer</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-list-groups.html" class="menu-link">
              <div data-i18n="List Groups">List Groups</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-modals.html" class="menu-link">
              <div data-i18n="Modals">Modals</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-navbar.html" class="menu-link">
              <div data-i18n="Navbar">Navbar</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-offcanvas.html" class="menu-link">
              <div data-i18n="Offcanvas">Offcanvas</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-pagination-breadcrumbs.html" class="menu-link">
              <div data-i18n="Pagination & Breadcrumbs">Pagination &amp; Breadcrumbs</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-progress.html" class="menu-link">
              <div data-i18n="Progress">Progress</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-spinners.html" class="menu-link">
              <div data-i18n="Spinners">Spinners</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-tabs-pills.html" class="menu-link">
              <div data-i18n="Tabs & Pills">Tabs &amp; Pills</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-toasts.html" class="menu-link">
              <div data-i18n="Toasts">Toasts</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-tooltips-popovers.html" class="menu-link">
              <div data-i18n="Tooltips & Popovers">Tooltips &amp; Popovers</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="ui-typography.html" class="menu-link">
              <div data-i18n="Typography">Typography</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Extended components -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-box-3-line"></i>
          <div data-i18n="Extended UI">Extended UI</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
              <div data-i18n="Perfect Scrollbar">Perfect Scrollbar</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="extended-ui-text-divider.html" class="menu-link">
              <div data-i18n="Text Divider">Text Divider</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Icons -->
      <li class="menu-item">
        <a href="icons-ri.html" class="menu-link">
          <i class="menu-icon icon-base ri ri-remixicon-line"></i>
          <div data-i18n="Icons">Icons</div>
        </a>
      </li>

      <!-- Forms & Tables -->
      <li class="menu-header mt-7"><span class="menu-header-text">Forms &amp; Tables</span></li>
      <!-- Forms -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-radio-button-line"></i>
          <div data-i18n="Form Elements">Form Elements</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="forms-basic-inputs.html" class="menu-link">
              <div data-i18n="Basic Inputs">Basic Inputs</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="forms-input-groups.html" class="menu-link">
              <div data-i18n="Input groups">Input groups</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base ri ri-box-3-line"></i>
          <div data-i18n="Form Layouts">Form Layouts</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="form-layouts-vertical.html" class="menu-link">
              <div data-i18n="Vertical Form">Vertical Form</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="form-layouts-horizontal.html" class="menu-link">
              <div data-i18n="Horizontal Form">Horizontal Form</div>
            </a>
          </li>
        </ul>
      </li>
      <!-- Form Validation -->
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/form-validation.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-checkbox-multiple-line"></i>
          <div data-i18n="Form Validation">Form Validation</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <!-- Tables -->
      <li class="menu-item">
        <a href="tables-basic.html" class="menu-link">
          <i class="menu-icon icon-base ri ri-table-alt-line"></i>
          <div data-i18n="Tables">Tables</div>
        </a>
      </li>
      <!-- Data Tables -->
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/html/vertical-menu-template/tables-datatables-basic.html"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-grid-line"></i>
          <div data-i18n="Datatables">Datatables</div>
          <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">Pro</div>
        </a>
      </li>
      <!-- Misc -->
      <li class="menu-header mt-7"><span class="menu-header-text">Misc</span></li>
      <li class="menu-item">
        <a
          href="https://github.com/themeselection/materio-bootstrap-html-admin-template-free/issues"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-lifebuoy-line"></i>
          <div data-i18n="Support">Support</div>
        </a>
      </li>
      <li class="menu-item">
        <a
          href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/documentation/"
          target="_blank"
          class="menu-link">
          <i class="menu-icon icon-base ri ri-article-line"></i>
          <div data-i18n="Documentation">Documentation</div>
        </a>
      </li> --}}
    </ul>
</aside>
