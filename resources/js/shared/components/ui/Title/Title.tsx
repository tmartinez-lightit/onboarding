interface TitleProps {
  title: string;
}

export const Title = ({ title }: TitleProps) => (
  <h1 className="mb-5 text-2xl font-semibold text-gray-900">{title}</h1>
);
