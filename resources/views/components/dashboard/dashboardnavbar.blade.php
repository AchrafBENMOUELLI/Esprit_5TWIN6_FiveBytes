<style>
    .aq-modern-navbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 240px;
        height: 72px;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 32px;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    @media (max-width: 991px) {
        .aq-modern-navbar {
            left: 0;
        }
    }

    .aq-navbar-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .aq-navbar-title {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .aq-navbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .aq-nav-icon-btn {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f3f4f6;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .aq-nav-icon-btn:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .aq-nav-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #ef4444;
        color: white;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    .aq-user-dropdown {
        position: relative;
    }

    .aq-user-trigger {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 12px 6px 6px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .aq-user-trigger:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    .aq-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
        flex-shrink: 0;
    }

    .aq-user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .aq-user-name {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.2;
    }

    .aq-user-role {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.2;
    }

    .aq-dropdown-icon {
        color: #9ca3af;
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .aq-user-dropdown.active .aq-dropdown-icon {
        transform: rotate(180deg);
    }

    .aq-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 240px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1001;
    }

    .aq-user-dropdown.active .aq-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .aq-dropdown-header {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
    }

    .aq-dropdown-user-name {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .aq-dropdown-user-email {
        font-size: 13px;
        color: #6b7280;
    }

    .aq-dropdown-body {
        padding: 8px;
    }

    .aq-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .aq-dropdown-item:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    .aq-dropdown-item i {
        width: 18px;
        text-align: center;
        font-size: 16px;
    }

    .aq-dropdown-divider {
        height: 1px;
        background: #f3f4f6;
        margin: 8px 0;
    }

    .aq-dropdown-logout {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        background: none;
        border: none;
        color: #ef4444;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
        cursor: pointer;
        text-align: left;
    }

    .aq-dropdown-logout:hover {
        background: #fef2f2;
    }

    .aq-dropdown-logout i {
        width: 18px;
        text-align: center;
        font-size: 16px;
    }

    /* Role badge */
    .aq-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .aq-role-badge.admin {
        background: #dbeafe;
        color: #1e40af;
    }

    .aq-role-badge.citoyen {
        background: #d1fae5;
        color: #065f46;
    }
</style>

<header class="aq-modern-navbar">
    <div class="aq-navbar-left">
        <h2 class="aq-navbar-title">Back Office</h2>
    </div>

    <div class="aq-navbar-right">
        {{-- Notifications --}}
        <button class="aq-nav-icon-btn" title="Notifications">
            <i class="fas fa-bell"></i>
            <span class="aq-nav-badge">3</span>
        </button>

        {{-- Settings --}}
        <button class="aq-nav-icon-btn" title="Paramètres">
            <i class="fas fa-cog"></i>
        </button>

        {{-- User Dropdown --}}
        <div class="aq-user-dropdown" id="userDropdown">
            <div class="aq-user-trigger" onclick="toggleUserDropdown()">
                <div class="aq-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="aq-user-info">
                    <span class="aq-user-name">{{ auth()->user()->name }}</span>
                    <span class="aq-user-role">{{ ucfirst(auth()->user()->role->value) }}</span>
                </div>
                <i class="fas fa-chevron-down aq-dropdown-icon"></i>
            </div>

            <div class="aq-dropdown-menu">
                <div class="aq-dropdown-header">
                    <div class="aq-dropdown-user-name">{{ auth()->user()->name }}</div>
                    <div class="aq-dropdown-user-email">{{ auth()->user()->email }}</div>
                    <div class="mt-2">
                        <span class="aq-role-badge {{ auth()->user()->role->value }}">
                            <i class="fas fa-shield-alt"></i>
                            {{ ucfirst(auth()->user()->role->value) }}
                        </span>
                    </div>
                </div>

                <div class="aq-dropdown-body">
                    <a href="{{ route('dashboard') }}" class="aq-dropdown-item">
                        <i class="fas fa-user"></i>
                        Mon Profil
                    </a>
                    <a href="#" class="aq-dropdown-item">
                        <i class="fas fa-cog"></i>
                        Paramètres
                    </a>
                    <a href="#" class="aq-dropdown-item">
                        <i class="fas fa-question-circle"></i>
                        Aide & Support
                    </a>

                    <div class="aq-dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="submit" class="aq-dropdown-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown && !dropdown.contains(event.target)) {
        dropdown.classList.remove('active');
    }
});
</script>
