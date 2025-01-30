import { ArrowPathIcon } from "@heroicons/react/24/outline";
import { tv } from "tailwind-variants";
import type { VariantProps } from "tailwind-variants";

import { tw } from "~/utils";

const spinnerVariants = tv({
  base: "text-muted-foreground animate-spin",
  variants: {
    size: {
      sm: "size-4",
      md: "size-6",
      lg: "size-8",
    },
  },
  defaultVariants: {
    size: "md",
  },
});

interface SpinnerProps extends VariantProps<typeof spinnerVariants> {
  className?: string;
}

export const Spinner = ({ className, size }: SpinnerProps) => (
  <ArrowPathIcon className={tw(spinnerVariants({ size, className }))} />
);
