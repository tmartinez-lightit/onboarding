import { forwardRef, useEffect, useRef, useState } from "react";

export type SelectOption = {
  value: string | number;
  label: string;
};

type SelectProps = {
  options?: SelectOption[];
  isMulti?: boolean;
  onChange?: (value: SelectOption | SelectOption[] | null) => void;
  placeholder?: string;
  className?: string;
  error?: string;
  value?: SelectOption | SelectOption[] | null;
};

export const Select = forwardRef<HTMLDivElement, SelectProps>(
  (
    {
      options = [],
      isMulti = false,
      onChange,
      placeholder,
      className = "",
      error,
      value,
    },
    ref,
  ) => {
    const [isOpen, setIsOpen] = useState(false);
    const [selectedOptions, setSelectedOptions] = useState<SelectOption[]>([]);
    const [searchTerm, setSearchTerm] = useState("");
    const containerRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
      if (value) {
        setSelectedOptions(Array.isArray(value) ? value : [value]);
      }
    }, [value]);

    useEffect(() => {
      const handleClickOutside = (event: MouseEvent) => {
        if (
          containerRef.current &&
          !containerRef.current.contains(event.target as Node)
        ) {
          setIsOpen(false);
        }
      };

      document.addEventListener("mousedown", handleClickOutside);
      return () =>
        document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    const filteredOptions = options.filter(
      (option) =>
        option.label.toLowerCase().includes(searchTerm.toLowerCase()) &&
        !selectedOptions.some((selected) => selected.value === option.value),
    );

    const handleSelect = (option: SelectOption) => {
      let newValue: SelectOption | SelectOption[] | null;

      if (isMulti) {
        newValue = [...selectedOptions, option];
        setSelectedOptions(newValue);
      } else {
        newValue = option;
        setSelectedOptions([option]);
        setIsOpen(false);
      }

      onChange?.(newValue);
    };

    const handleRemove = (
      optionToRemove: SelectOption,
      event: React.MouseEvent,
    ) => {
      event.stopPropagation();
      const newValue = selectedOptions.filter(
        (option) => option.value !== optionToRemove.value,
      );
      setSelectedOptions(newValue);
      onChange?.(isMulti ? newValue : null);
    };

    return (
      <div ref={containerRef} className="relative">
        <div
          ref={ref}
          className={`min-h-[38px] cursor-pointer rounded-lg border px-2 py-1 shadow-sm ${
            error
              ? "border-red-300 focus-within:border-red-500 focus-within:ring-red-500"
              : "focus-within:border-primary-500 focus-within:ring-primary-500 border-gray-300"
          } focus-within:ring-1 ${className}`}
          onClick={() => setIsOpen(true)}
        >
          <div className="flex flex-wrap gap-1">
            {selectedOptions.length > 0 ? (
              selectedOptions.map((option) => (
                <span
                  key={option.value}
                  className="bg-primary-50 text-primary-900 flex items-center gap-1 rounded-md px-2 py-1 text-sm"
                >
                  {option.label}
                  <button
                    onClick={(e) => handleRemove(option, e)}
                    className="text-primary-500 hover:text-primary-900 hover:bg-primary-100 ml-1 rounded-md"
                  >
                    ×
                  </button>
                </span>
              ))
            ) : (
              <span className="text-gray-400">{placeholder}</span>
            )}
            <input
              type="text"
              className="min-w-[50px] flex-1 bg-transparent text-gray-900 outline-none"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              onFocus={() => setIsOpen(true)}
            />
          </div>
        </div>

        {isOpen && (
          <div className="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-lg border border-gray-300 bg-white shadow-lg">
            {filteredOptions.length > 0 ? (
              filteredOptions.map((option) => (
                <div
                  key={option.value}
                  className="cursor-pointer px-3 py-2 hover:bg-gray-50"
                  onClick={() => handleSelect(option)}
                >
                  {option.label}
                </div>
              ))
            ) : (
              <div className="px-3 py-2 text-gray-500">
                No options available
              </div>
            )}
          </div>
        )}

        {error && <p className="mt-1 text-sm text-red-600">{error}</p>}
      </div>
    );
  },
);

Select.displayName = "Select";
