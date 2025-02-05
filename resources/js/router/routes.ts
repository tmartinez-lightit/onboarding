export const ROUTES = {
  base: "/cities",
  cities: "/cities",
  airlines: {
    base: "/airlines",
    detail: "/airlines/:id",
  },
  notFound: "*",
} as const;
