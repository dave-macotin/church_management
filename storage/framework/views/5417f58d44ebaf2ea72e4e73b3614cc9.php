<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(App\Models\Setting::get('church_name', 'Grace Church')); ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;500;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-deep:      #0e0703;
            --bg-panel:     #1a0f05;
            --bg-card:      #221208;
            --gold-bright:  #EF9F27;
            --gold-mid:     #FAC775;
            --gold-muted:   #c8a97a;
            --cream:        #FAEEDA;
            --accent:       #D85A30;
            --border:       rgba(200, 169, 122, 0.18);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-deep);
            color: var(--cream);
            overflow-x: hidden;
        }

        h1, h2, h3, .font-cinzel { font-family: 'Cinzel', serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }

        .glass-nav {
            background: rgba(14, 7, 3, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .hero-section {
            position: relative;
            height: 90vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(14, 7, 3, 0.5), rgba(14, 7, 3, 0.9)), url('/images/hero.png');
            background-size: cover;
            background-position: center;
        }

        .btn-gold {
            background: var(--gold-bright);
            color: #000;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-gold:hover {
            background: var(--gold-mid);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 159, 39, 0.4);
        }

        .btn-outline {
            border: 1px solid var(--gold-bright);
            color: var(--gold-bright);
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: rgba(239, 159, 39, 0.1);
            transform: translateY(-2px);
        }

        .feature-card {
            background: var(--bg-panel);
            border: 1px solid var(--border);
            padding: 2.5rem;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .feature-card:hover {
            border-color: var(--gold-bright);
            transform: translateY(-5px);
        }

        .section-title {
            font-size: 2.5rem;
            color: var(--gold-mid);
            margin-bottom: 3rem;
            text-align: center;
        }

        .sermon-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .sermon-card:hover { transform: scale(1.02); }

        footer {
            background: #080402;
            border-top: 1px solid var(--border);
            padding: 4rem 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="glass-nav py-4 px-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="relative w-10 h-10">
                <div class="absolute inset-0 bg-gold-bright translate-x-1.5 translate-y-1.5 opacity-20"></div>
                <div class="relative w-10 h-10 border-2 border-gold-bright flex items-center justify-center font-cinzel text-xl font-bold text-gold-bright">
                    G
                </div>
            </div>
            <span class="font-cinzel text-lg tracking-widest hidden md:block" style="color:var(--gold-mid)">GRACE CHURCH</span>
        </div>

        <div class="flex items-center gap-6">
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="btn-gold text-sm py-2 px-6">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium hover:text-gold-bright transition-colors">Login</a>
                    <?php if(Route::has('register')): ?>
                        <a href="<?php echo e(route('register')); ?>" class="btn-gold text-sm py-2 px-6">Join Us</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </nav>

    <header class="hero-section px-4">
        <div class="max-w-4xl mx-auto" style="animation: fadeInUp 1s ease-out;">
            <h2 class="font-cinzel text-lg md:text-xl tracking-[0.3em] mb-4 text-gold-bright opacity-80">WELCOME TO</h2>
            <h1 class="font-cinzel text-4xl md:text-7xl mb-8 leading-tight" style="color:var(--cream)">Building a Community of <span style="color:var(--gold-mid)">Faith & Hope</span></h1>
            <p class="font-outfit text-lg md:text-xl mb-10 max-w-2xl mx-auto opacity-70">Experience spiritual growth and meaningful connection in a modern ministry dedicated to sharing God's love.</p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="#about" class="btn-gold">Our Mission</a>
                <a href="<?php echo e(route('login')); ?>" class="btn-outline">Member Access</a>
            </div>
        </div>
    </header>

    <section id="about" class="py-24 px-6 md:px-12 bg-panel">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card text-center">
                    <div class="text-4xl mb-6">📖</div>
                    <h3 class="text-xl mb-4 text-gold-mid">The Word</h3>
                    <p class="text-sm opacity-60">Grounded in scriptural truth, we seek to apply eternal wisdom to our contemporary lives.</p>
                </div>
                <div class="feature-card text-center">
                    <div class="text-4xl mb-6">🤝</div>
                    <h3 class="text-xl mb-4 text-gold-mid">Community</h3>
                    <p class="text-sm opacity-60">A diverse family where everyone is welcome, valued, and encouraged on their journey.</p>
                </div>
                <div class="feature-card text-center">
                    <div class="text-4xl mb-6">🕊️</div>
                    <h3 class="text-xl mb-4 text-gold-mid">Service</h3>
                    <p class="text-sm opacity-60">Extending God’s grace through local and global ministry to those in need.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12">
        <div class="max-w-6xl mx-auto">
            <h2 class="section-title">Latest Ministries</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Sermon Card Placeholder -->
                <div class="sermon-card group">
                    <div class="aspect-video bg-black/40 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1438232992991-995b7058bbb3?q=80&w=1000" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" alt="Sermon">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white scale-0 group-hover:scale-100 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-[10px] uppercase tracking-widest font-bold mb-2 text-gold-muted">Recent Sermon</div>
                        <h4 class="text-lg mb-3 text-gold-mid">Walking in Faith</h4>
                        <p class="text-xs opacity-50 mb-6">Discover how to navigate life's challenges with unwavering spiritual confidence.</p>
                        <a href="<?php echo e(route('login')); ?>" class="text-xs font-bold text-gold-bright border-b border-gold-bright/30 pb-1">Listen Now</a>
                    </div>
                </div>

                <!-- Event Card Placeholder -->
                <div class="sermon-card group">
                    <div class="aspect-video bg-black/40 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=1000" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" alt="Event">
                    </div>
                    <div class="p-6">
                        <div class="text-[10px] uppercase tracking-widest font-bold mb-2 text-gold-muted">Upcoming Event</div>
                        <h4 class="text-lg mb-3 text-gold-mid">Youth Fellowship Night</h4>
                        <p class="text-xs opacity-50 mb-6">Join us for an evening of worship, fun, and community for ages 13-18.</p>
                        <a href="<?php echo e(route('login')); ?>" class="text-xs font-bold text-gold-bright border-b border-gold-bright/30 pb-1">Event Details</a>
                    </div>
                </div>

                <!-- Mission Card Placeholder -->
                <div class="sermon-card group">
                    <div class="aspect-video bg-black/40 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=1000" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" alt="Mission">
                    </div>
                    <div class="p-6">
                        <div class="text-[10px] uppercase tracking-widest font-bold mb-2 text-gold-muted">Local Outreach</div>
                        <h4 class="text-lg mb-3 text-gold-mid">Helping Hands Project</h4>
                        <p class="text-xs opacity-50 mb-6">Our monthly initiative to provide support and resources to the local community.</p>
                        <a href="<?php echo e(route('login')); ?>" class="text-xs font-bold text-gold-bright border-b border-gold-bright/30 pb-1">Get Involved</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 md:px-12 bg-panel relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gold-bright opacity-5 blur-[120px]"></div>
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="font-cinzel text-3xl md:text-5xl mb-8" style="color:var(--gold-mid)">Become Part of Our Journey</h2>
            <p class="font-outfit text-lg opacity-70 mb-10">Whether you're looking for a spiritual home or just exploring, we'd love to meet you.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo e(route('register')); ?>" class="btn-gold">Create an Account</a>
                <a href="<?php echo e(route('login')); ?>" class="btn-outline">Sign In</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 text-left">
            <div>
                <h4 class="font-cinzel text-gold-mid mb-6 uppercase tracking-widest">About Us</h4>
                <p class="text-sm opacity-50 leading-loose">Grace Church is a modern ministry dedicated to personal growth, community service, and spiritual excellence.</p>
            </div>
            <div>
                <h4 class="font-cinzel text-gold-mid mb-6 uppercase tracking-widest">Connect</h4>
                <ul class="text-sm opacity-50 flex flex-col gap-3">
                    <li>Grace Church, 123 Ministry Lane</li>
                    <li>contact@gracechurch.example</li>
                    <li>(555) 000-1234</li>
                </ul>
            </div>
            <div>
                <h4 class="font-cinzel text-gold-mid mb-6 uppercase tracking-widest">Follow Us</h4>
                <div class="flex gap-4 text-xl">
                    <a href="#" class="opacity-50 hover:opacity-100 transition-opacity">𝕏</a>
                    <a href="#" class="opacity-50 hover:opacity-100 transition-opacity">📸</a>
                    <a href="#" class="opacity-50 hover:opacity-100 transition-opacity">▶️</a>
                </div>
            </div>
        </div>
        <div class="pt-8 border-t border-white/5 opacity-30 text-[10px] uppercase tracking-widest">
            &copy; <?php echo e(date('Y')); ?> <?php echo e(App\Models\Setting::get('church_name', 'Grace Church')); ?>. All rights reserved.
        </div>
    </footer>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
<?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/welcome.blade.php ENDPATH**/ ?>