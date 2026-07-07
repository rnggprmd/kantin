<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startSection('content'); ?>
<main class="flex w-full h-screen">

    
    <section class="hidden lg:flex flex-1 relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img class="w-full h-full object-cover animate-slow-zoom"
                 src="https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=2070&auto=format&fit=crop"
                 alt="Kantin Interior">
            <div class="absolute inset-0 mix-blend-multiply" style="background-color:rgba(21,23,61,0.82);"></div>
        </div>
        <div class="relative z-10 px-14 max-w-xl text-white">
            <div class="flex items-center gap-4 mb-8 animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0;">
                <span class="material-symbols-outlined" style="font-size:52px;color:#ffd7f6;">restaurant</span>
                <h1 class="font-headline font-extrabold text-4xl tracking-tight">SMK PURNAMA 1 JAKARTA</h1>
            </div>
            <h2 class="font-headline font-bold text-3xl leading-tight mb-5 animate-fade-in-up" style="animation-delay: 0.4s; opacity: 0;">
                Tingkatkan pengalaman<br>makan di sekolah Anda.
            </h2>
            <p class="text-white/75 text-lg leading-relaxed animate-fade-in-up" style="animation-delay: 0.6s; opacity: 0;">
                Perencanaan makan efisien, pembayaran lancar, dan kejelasan nutrisi untuk komunitas sekolah modern.
            </p>
            <div class="mt-10 grid grid-cols-2 gap-4">
                <div class="rounded-2xl p-5 border border-white/20 animate-fade-in-up" style="background:rgba(255,255,255,0.1);backdrop-filter:blur(12px); animation-delay: 0.8s; opacity: 0;">
                    <span class="material-symbols-outlined block mb-3" style="color:#ffd7f6;font-size:28px;">bolt</span>
                    <p class="text-[11px] uppercase tracking-widest text-white/55 font-semibold mb-1">Akses Cepat</p>
                    <p class="font-headline font-bold text-lg">Pembayaran Kilat</p>
                </div>
                <div class="rounded-2xl p-5 border border-white/20 animate-fade-in-up" style="background:rgba(255,255,255,0.1);backdrop-filter:blur(12px); animation-delay: 1s; opacity: 0;">
                    <span class="material-symbols-outlined block mb-3" style="color:#ffd7f6;font-size:28px;">health_and_safety</span>
                    <p class="text-[11px] uppercase tracking-widest text-white/55 font-semibold mb-1">Keamanan Utama</p>
                    <p class="font-headline font-bold text-lg">Kontrol Nutrisi</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="flex-1 flex flex-col relative overflow-hidden" style="background:#f8f9fa;">

        
        <span class="material-symbols-outlined floating-icon float-1">restaurant</span>
        <span class="material-symbols-outlined floating-icon float-2">eco</span>
        <span class="material-symbols-outlined floating-icon float-3">local_cafe</span>

        
        <div class="flex-1 flex items-center justify-center overflow-y-auto px-6 sm:px-16 py-10 relative z-10">
            <div class="w-full max-w-[420px] animate-breath">

                
                <div class="flex lg:hidden items-center gap-3 mb-8">
                    <span class="material-symbols-outlined" style="color:#15173d;font-size:34px;">restaurant</span>
                    <span class="font-headline font-extrabold text-2xl" style="color:#15173d;">SMK PURNAMA 1 JAKARTA</span>
                </div>

                
                <div class="mb-8">
                    <h3 class="font-headline font-bold text-[32px] leading-tight mb-2 animate-slide-in" style="color:#191c1d;">
                        Selamat Datang
                    </h3>
                    <p class="text-[15px]" style="color:#46464e;">
                        Silakan masukkan detail Anda untuk mengakses akun.
                    </p>
                </div>

                
                <?php if(session('error') || $errors->any()): ?>
                <div class="flex items-center gap-3 p-4 rounded-2xl mb-6 text-sm font-medium"
                     style="background:#ffdad6;color:#93000a;border:1px solid rgba(186,26,26,0.25);">
                    <span class="material-symbols-outlined shrink-0" style="font-size:20px;">error</span>
                    <?php echo e(session('error') ?? $errors->first()); ?>

                </div>
                <?php endif; ?>

                
                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div class="flex flex-col gap-5">

                        
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-widest mb-2"
                                   style="color:#46464e;" for="username">Username</label>
                            <div class="relative">
                                <input
                                    id="username" name="username" type="text"
                                    placeholder="Masukkan username Anda"
                                    value="<?php echo e(old('username')); ?>"
                                    required autofocus
                                    class="w-full rounded-2xl text-sm transition-all outline-none"
                                    style="padding:13px 48px 13px 18px;background:#fff;border:1.5px solid #c7c5cf;color:#191c1d;"
                                />
                                <span class="material-symbols-outlined absolute top-1/2 -translate-y-1/2 right-4 pointer-events-none"
                                      style="font-size:20px;color:#77767f;">person</span>
                            </div>
                        </div>

                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[11px] font-bold uppercase tracking-widest"
                                       style="color:#46464e;" for="password">Kata Sandi</label>
                            </div>
                            <div class="relative">
                                <input
                                    id="password" name="password" type="password"
                                    placeholder="••••••••"
                                    required
                                    class="w-full rounded-2xl text-sm transition-all outline-none"
                                    style="padding:13px 48px 13px 18px;background:#fff;border:1.5px solid #c7c5cf;color:#191c1d;"
                                />
                                <span class="material-symbols-outlined absolute top-1/2 -translate-y-1/2 right-4 pointer-events-none"
                                      style="font-size:20px;color:#77767f;">lock</span>
                            </div>
                        </div>

                        
                        <div class="pt-2">
                            <div class="border-t w-full" style="border-color:rgba(199,197,207,0.5);"></div>
                        </div>

                        
                        <button type="submit"
                                class="btn-liquid w-full py-3.5 rounded-2xl font-headline font-bold text-base flex items-center justify-center gap-2 shadow-md transition-transform active:scale-[0.98]"
                                style="background:#9d2a9d;color:#fff;">
                            <span>Masuk</span>
                            <span class="material-symbols-outlined" style="font-size:20px;">arrow_forward</span>
                        </button>

                    </div>
                </form>

            </div>
        </div>

        
        <footer class="shrink-0 text-center py-4 px-6" style="border-top:1px solid rgba(199,197,207,0.4);">
            <p class="text-[11px]" style="color:#77767f;">
                © <?php echo e(date('Y')); ?> Sistem Kantin SMK PURNAMA 1 JAKARTA &bull; Kebijakan Privasi &bull; Ketentuan Layanan
            </p>
        </footer>

    </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kantin\resources\views/auth/login.blade.php ENDPATH**/ ?>