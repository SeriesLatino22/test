// Navegación y scroll
const header = document.getElementById('header');
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');
const navLinks = document.querySelectorAll('.nav-link');

// Header scroll effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Mobile menu toggle
menuToggle.addEventListener('click', () => {
    header.classList.toggle('menu-open');
    menuToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Cerrar menú al hacer click en un enlace
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        header.classList.remove('menu-open');
        menuToggle.classList.remove('active');
        navMenu.classList.remove('active');
    });
});

// Smooth scroll para enlaces internos
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerHeight = header.offsetHeight;
            const targetPosition = target.offsetTop - headerHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Activar enlace de navegación según sección visible
const sections = document.querySelectorAll('section[id]');

function activateNavLink() {
    const scrollY = window.pageYOffset;

    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

window.addEventListener('scroll', activateNavLink);

// Animaciones de scroll reveal
const revealElements = document.querySelectorAll('.reveal');

const revealOnScroll = () => {
    const windowHeight = window.innerHeight;
    const revealPoint = 100;

    revealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;

        if (elementTop < windowHeight - revealPoint) {
            element.classList.add('active');
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
revealOnScroll(); // Ejecutar al cargar

// Contador animado para estadísticas
const animateCounters = () => {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200; // Velocidad de animación

    counters.forEach(counter => {
        const target = counter.textContent;
        const numericTarget = parseInt(target.replace(/\D/g, ''));
        const suffix = target.replace(/[0-9]/g, '');

        if (isNaN(numericTarget)) return;

        let count = 0;
        const increment = numericTarget / speed;

        const updateCounter = () => {
            count += increment;

            if (count < numericTarget) {
                counter.textContent = Math.ceil(count) + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        // Iniciar animación cuando el elemento sea visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(counter);
    });
};

// Ejecutar animación de contadores
animateCounters();

// Manejo del formulario de contacto
const contactForm = document.getElementById('contactForm');

if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = contactForm.querySelector('.submit-btn');
        const originalText = submitBtn.textContent;

        // Deshabilitar botón y mostrar estado de carga
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';
        submitBtn.style.opacity = '0.7';

        try {
            const formData = new FormData(contactForm);

            const response = await fetch('process-contact.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Mostrar mensaje de éxito
                showMessage('¡Mensaje enviado exitosamente! Nos pondremos en contacto pronto.', 'success');
                contactForm.reset();
            } else {
                showMessage(result.message || 'Error al enviar el mensaje. Por favor, intenta nuevamente.', 'error');
            }
        } catch (error) {
            showMessage('Error al enviar el mensaje. Por favor, intenta nuevamente.', 'error');
        } finally {
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            submitBtn.style.opacity = '1';
        }
    });
}

// Función para mostrar mensajes
function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `form-message ${type}`;
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        padding: 1rem 1.5rem;
        margin-top: 1rem;
        border-radius: 8px;
        font-weight: 600;
        animation: slideDown 0.3s ease-out;
        ${type === 'success' ? 'background: #d1fae5; color: #065f46;' : 'background: #fee2e2; color: #991b1b;'}
    `;

    contactForm.appendChild(messageDiv);

    // Remover mensaje después de 5 segundos
    setTimeout(() => {
        messageDiv.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => messageDiv.remove(), 300);
    }, 5000);
}

// Efecto de desvanecimiento suave para el Hero al hacer scroll
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const heroContent = document.querySelector('.hero-content');

    if (heroContent) {
        // El texto se vuelve transparente a medida que bajas
        const opacity = 1 - (scrolled / 500);
        if (opacity >= 0) {
            heroContent.style.opacity = opacity;
            heroContent.style.transform = `translateY(${scrolled * 0.2}px)`; // Movimiento suave
        }
    }
});

// Prevenir envío de formulario duplicado
let formSubmitting = false;

if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        if (formSubmitting) {
            e.preventDefault();
            return false;
        }
        formSubmitting = true;

        setTimeout(() => {
            formSubmitting = false;
        }, 3000);
    });
}

// Lazy loading para imágenes (si se agregan)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Efecto de typing para el título (opcional)
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.textContent = '';

    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

// Validación mejorada del formulario
if (contactForm) {
    const inputs = contactForm.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('blur', () => {
            validateInput(input);
        });

        input.addEventListener('input', () => {
            if (input.classList.contains('invalid')) {
                validateInput(input);
            }
        });
    });
}

function validateInput(input) {
    const value = input.value.trim();

    // Remover mensaje de error previo
    const existingError = input.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    input.classList.remove('invalid');

    // Validaciones
    if (input.hasAttribute('required') && !value) {
        showInputError(input, 'Este campo es obligatorio');
        return false;
    }

    if (input.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showInputError(input, 'Email inválido');
            return false;
        }
    }

    if (input.type === 'tel' && value) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        if (!phoneRegex.test(value)) {
            showInputError(input, 'Teléfono inválido');
            return false;
        }
    }

    return true;
}

function showInputError(input, message) {
    input.classList.add('invalid');

    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        animation: slideDown 0.2s ease-out;
    `;

    input.parentElement.appendChild(errorDiv);
}

// Agregar estilos para inputs inválidos
const style = document.createElement('style');
style.textContent = `
    input.invalid, textarea.invalid {
        border-color: #ef4444 !important;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

console.log('✅ TransLog Pro - Sistema cargado correctamente');

// --- LÓGICA DEL PRELOADER ---
const preloader = document.getElementById('preloader');

// Verificar si ya se mostró en esta sesión
if (sessionStorage.getItem('preloaderShown')) {
    if (preloader) preloader.style.display = 'none';
    document.body.style.overflow = 'visible';
} else {
    document.body.style.overflow = 'hidden';

    window.addEventListener('load', () => {
        const progressBar = document.getElementById('loaderProgressBar');
        const percentText = document.getElementById('loaderPercent');
        const statusText = document.querySelector('.loader-status');

        if (!preloader || !progressBar || !percentText) return;

        let progress = 0;
        const items = [
            "Verificando flota...",
            "Cargando rutas óptimas...",
            "Sincronizando GPS...",
            "Carga lista!"
        ];

        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;

            progressBar.style.width = `${progress}%`;
            percentText.textContent = `${Math.round(progress)}%`;

            if (progress < 30) statusText.textContent = items[0];
            else if (progress < 60) statusText.textContent = items[1];
            else if (progress < 90) statusText.textContent = items[2];
            else statusText.textContent = items[3];

            if (progress >= 100) {
                clearInterval(interval);
                // Marcar como mostrado
                sessionStorage.setItem('preloaderShown', 'true');

                setTimeout(() => {
                    preloader.classList.add('fade-out');
                    document.body.style.overflow = 'visible';
                }, 500);
            }
        }, 150);
    });
}
