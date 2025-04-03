import './bootstrap';


tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                light: {
                    text: '#4b4035',
                    background: '#f6f3e4',
                    primary: '#a67a59',
                    secondary: '#6c4b41',
                    accent: '#219cba'
                },
                dark: {
                    text: '#cabfb4',
                    background: '#1a1709',
                    primary: '#a67a59',
                    secondary: '#be9d93',
                    accent: '#45bfde',
                },
            },
            fontSize: {
                'sm': '0.750rem',
                'base': '1rem',
                'xl': '1.333rem',
                '2xl': '1.777rem',
                '3xl': '2.369rem',
                '4xl': '3.158rem',
                '5xl': '4.210rem',
            },
            fontFamily: {
                'heading': ['Zen Old Mincho'],
                'body': ['Zen Old Mincho'],
            },
            keyframes: {
                'fade-in-up': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(20px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    }
                },
                'fade-in-left': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateX(-20px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateX(0)'
                    }
                }
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.5s ease-out',
                'fade-in-left': 'fade-in-left 0.5s ease-out'
            }
        },
    },
}
