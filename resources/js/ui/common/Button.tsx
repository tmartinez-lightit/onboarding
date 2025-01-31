import type { ComponentPropsWithoutRef, ForwardedRef } from "react";

import { forwardRef, tw } from "~/utils";

const BUTTON_VARIANT = {
  PRIMARY: "primary",
  SECONDARY: "secondary",
  OUTLINE: "outline",
  TERTIARY: "tertiary",
  GHOST: "ghost",
  COMPACT: "compact",
} as const;
type ButtonVariant = (typeof BUTTON_VARIANT)[keyof typeof BUTTON_VARIANT];

const SIZE = {
  SMALL: "sm",
  MEDIUM: "md",
  LARGE: "lg",
} as const;
type Size = (typeof SIZE)[keyof typeof SIZE];

const SPACING = {
  TIGHT: "tight",
  NORMAL: "normal",
  LOOSE: "loose",
} as const;
type Spacing = (typeof SPACING)[keyof typeof SPACING];

export interface ButtonProps extends ComponentPropsWithoutRef<"button"> {
  variant?: ButtonVariant;
  size?: Size;
  spacing?: Spacing;
}

export const Button = forwardRef(
  (
    {
      type = "button",
      className,
      variant = "primary",
      size = "md",
      spacing,
      disabled = false,
      children,
      ...props
    }: ButtonProps,
    ref: ForwardedRef<HTMLButtonElement>,
  ) => (
    <button
      ref={ref}
      type={type}
      className={tw(
        "flex items-center justify-center gap-2 rounded-md border border-transparent font-medium focus:outline-none focus:ring focus:ring-blue-500",

        !disabled && [
          variant === BUTTON_VARIANT.PRIMARY &&
            "bg-blue-800 text-white hover:bg-blue-700",
          variant === BUTTON_VARIANT.SECONDARY &&
            "bg-blue-100 text-blue-800 hover:bg-blue-200",
          variant === BUTTON_VARIANT.OUTLINE &&
            "border-gray-300 text-gray-300 hover:border-gray-400 hover:text-gray-800",
          variant === BUTTON_VARIANT.TERTIARY &&
            "font-normal text-gray-500 hover:text-gray-600",
          variant === BUTTON_VARIANT.GHOST &&
            "border-none text-gray-500 shadow-none hover:opacity-75 focus:bg-gray-100 focus:ring-0 active:opacity-85",
        ],

        disabled && [
          variant === BUTTON_VARIANT.PRIMARY && "bg-gray-300 text-gray-500",
          variant === BUTTON_VARIANT.SECONDARY && "bg-gray-300",
          variant === BUTTON_VARIANT.OUTLINE && "border-gray-300 text-gray-300",
          variant === BUTTON_VARIANT.TERTIARY && "text-gray-300",
        ],

        size === SIZE.SMALL &&
          "rounded px-3 py-2 text-xs leading-none tracking-wider",
        size === SIZE.MEDIUM && "px-4 py-2 text-sm",
        size === SIZE.LARGE && "px-7 py-4 text-lg leading-[22px]",

        spacing === SPACING.TIGHT && "p-1",
        spacing === SPACING.NORMAL && "px-4 py-2",
        spacing === SPACING.LOOSE && "px-7 py-4",

        className,
      )}
      disabled={disabled}
      {...props}
    >
      {children}
    </button>
  ),
);
