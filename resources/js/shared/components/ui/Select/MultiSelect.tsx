import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxOption,
  ComboboxOptions,
} from "@headlessui/react";
import { CheckIcon, ChevronUpDownIcon } from "@heroicons/react/20/solid";

import { tw } from "~/utils";

export interface Option {
  id: number;
  label: string;
  [key: string]: string | number;
}

interface MultiSelectProps {
  options: Option[];
  value: Option[];
  onChange: (value: Option[]) => void;
  onSearch?: (query: string) => void;
  placeholder?: string;
  className?: string;
  disabled?: boolean;
}

export default function MultiSelect({
  options,
  value,
  onChange,
  onSearch,
  placeholder = "Select options...",
  className = "",
  disabled = false,
}: MultiSelectProps) {
  const handleSearch = (searchQuery: string) => {
    onSearch?.(searchQuery);
  };

  return (
    <Combobox
      value={value}
      onChange={onChange}
      multiple={true}
      disabled={disabled}
    >
      <div className={tw("relative mt-1", className)}>
        {value.length > 0 && (
          <ul>
            {value.map((item) => (
              <li key={item.id}>{item.label}</li>
            ))}
          </ul>
        )}
        <div className="relative w-full cursor-default overflow-hidden rounded-lg border border-gray-300 bg-white text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-300 sm:text-sm">
          <ComboboxInput
            className="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
            onChange={(event) => handleSearch(event.target.value)}
            placeholder={placeholder}
          />
          <ComboboxButton className="absolute inset-y-0 right-0 flex items-center pr-2">
            <ChevronUpDownIcon
              className="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
          </ComboboxButton>
        </div>
        <ComboboxOptions className="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          {options.length === 0 ? (
            <div className="relative cursor-default select-none px-4 py-2 text-gray-700">
              Nothing found.
            </div>
          ) : (
            options.map((option) => (
              <ComboboxOption
                key={option.id}
                className="relative cursor-default select-none py-2 pl-10 pr-4 text-gray-900"
                value={option}
              >
                {({ selected }) => (
                  <>
                    <span
                      className={tw(
                        "block truncate",
                        selected ? "font-medium" : "font-normal",
                      )}
                    >
                      {option.label}
                    </span>
                    {selected ? (
                      <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                        <CheckIcon className="h-5 w-5" aria-hidden="true" />
                      </span>
                    ) : null}
                  </>
                )}
              </ComboboxOption>
            ))
          )}
        </ComboboxOptions>
      </div>
    </Combobox>
  );
}
