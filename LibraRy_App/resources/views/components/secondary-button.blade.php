<button {{ $attributes->class(["py-3 px-4 bg-light-transparent dark:bg-dark-transparent border-2 border-light-primary  text-text rounded-lg hover:bg-light-secondary/10 dark:hover:bg-dark-secondary/10
                                hover:shadow-lg transition-all duration-300 relative overflow-hidden"]) }}>
    {{ $slot }}
</button>
